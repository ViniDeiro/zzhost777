<?php
  #======================================#
  ini_set('display_errors', 1);
  error_reporting(E_ALL);
  #======================================#
  session_start();
  include_once('../services/database.php');
  include_once('../services/funcao.php');
  include_once('../services/crud-adm.php');
  include_once('../services/crud.php');
  include_once('../logs/registrar_logs.php');
  include_once('../services/checa_login_adm.php');
  include_once("../services/CSRF_Protect.php");
  $csrf = new CSRF_Protect();
  #======================================#
  # Expulsa usuário não autorizado
  checa_login_adm();
  #======================================#

if (isset($_POST['att-pay']) && isset($_POST['_csrf']) && isset($_POST['id_pay']) && isset($_POST['valor_reprovado'])) {
    #----------------------------------------------#
    $id_pay = PHP_SEGURO($_POST['id_pay']);
    $valor_pay = floatval(str_replace(',', '.', $_POST['valor_reprovado'])); // Converte para float
    $CSRF = PHP_SEGURO($_POST['_csrf']);
    $data = date('Y-m-d H:i:s');
    #----------------------------------------------#

    // Verifica se o CSRF está vazio
    if (empty($CSRF)) {
        echo json_encode(['status' => 'error', 'message' => 'Houve um erro ao obter dados. Atualize sua página.']);
        exit;
    }

    // Obtém o ID do usuário associado ao saque
    $stmt = $mysqli->prepare("SELECT id_user FROM solicitacao_saques WHERE id = ?");
    $stmt->bind_param("i", $id_pay);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        echo json_encode(['status' => 'error', 'message' => 'Saque não encontrado.']);
        exit;
    }

    $user_id = $row['id_user'];

    // Atualiza o status do saque para "Recusado" (status = 2)
    $sql = $mysqli->prepare("UPDATE solicitacao_saques SET data_att = ?, status = 2 WHERE id = ?");
    $sql->bind_param("si", $data, $id_pay);

    if ($sql->execute()) {
        // Busca o saldo atual do usuário
        $stmt = $mysqli->prepare("SELECT saldo FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user_data = $result->fetch_assoc();

        if (!$user_data) {
            echo json_encode(['status' => 'error', 'message' => 'Usuário não encontrado.']);
            exit;
        }

        // Calcula o novo saldo do usuário
        $novo_saldo = $user_data['saldo'] + $valor_pay;

        // Atualiza o saldo do usuário na tabela "usuarios"
        $stmt = $mysqli->prepare("UPDATE usuarios SET saldo = ? WHERE id = ?");
        $stmt->bind_param("di", $novo_saldo, $user_id);

        if ($stmt->execute()) {
            // Registra o log da operação
            registrarLog($mysqli, $_SESSION['data_adm']['email'], "Recusou o saque ID: $id_pay e devolveu R$ $valor_pay para usuário ID: $user_id.");

            // Responde com sucesso em JSON
            echo json_encode(['status' => 'success', 'message' => 'Saque recusado e saldo devolvido com sucesso!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erro ao devolver o saldo do usuário.']);
        }
    } else {
        // Responde com erro em JSON
        echo json_encode(['status' => 'error', 'message' => 'Não foi possível recusar o saque.']);
    }

    $mysqli->close();
    exit;
}
?>
