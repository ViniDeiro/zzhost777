import { r as reactExports, x as useNavigate, q as useUserInfoStore, K as jsxRuntimeExports, S as trans, bs as postMemberPasswordUpdate, a7 as Message } from "./index-a_Ow1xUN-2024_8_30_15_11.js";
import { af as PasswordInput, B as Button } from "./App-D9NLPZJN-2024_8_30_15_11.js";
const svg_theme_fill_color = "_svg_theme_fill_color_kzj5t_3";
const container = "_container_kzj5t_55";
const tips1 = "_tips1_kzj5t_58";
const tips2 = "_tips2_kzj5t_126";
const tips3 = "_tips3_kzj5t_170";
const css = {
  svg_theme_fill_color,
  container,
  tips1,
  tips2,
  tips3
};
const WithdrawSet = () => {
  const [password, setPassword] = reactExports.useState("");
  const [old_password, setOldPassword] = reactExports.useState("");
  const navigate = useNavigate();
  const { getWithdrawPsdStatus, getUserInfoByStore } = useUserInfoStore();
  const submitIsDisabled = reactExports.useMemo(() => {
    return password.length !== 6 || old_password.length !== 6 || password !== old_password;
  }, [password, old_password]);
  const submit = async () => {
    const search = window.location.search;
    const params = new URLSearchParams(search);
    const to = params.get("to");
    const [res, error] = await postMemberPasswordUpdate({
      ty: "2",
      password,
      old_password
    });
    if (!error) {
      Message.success(trans("设置成功"));
      getWithdrawPsdStatus();
      getUserInfoByStore();
      setTimeout(() => {
        if (to) {
          navigate("/".concat(to), { replace: true });
        } else {
          navigate(-1);
        }
      }, 500);
      return;
    } else {
      Message.error(trans("设置失败"));
    }
  };
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.container, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsx("p", { className: css.tips1, children: trans("您是第一次提现，需要先设置提现密码") }),
    /* @__PURE__ */ jsxRuntimeExports.jsx("p", { className: css.tips2, children: trans("设置提现密码") }),
    /* @__PURE__ */ jsxRuntimeExports.jsx(
      PasswordInput,
      {
        title: trans("新提币密码"),
        onChange: (_value) => {
          setPassword(_value);
        }
      }
    ),
    /* @__PURE__ */ jsxRuntimeExports.jsx(
      PasswordInput,
      {
        title: trans("确认提现密码"),
        onChange: (_value) => {
          console.error("onChange", _value);
          setOldPassword(_value);
        }
      }
    ),
    /* @__PURE__ */ jsxRuntimeExports.jsx("p", { className: css.tips3, children: trans("您是第一次提现，需要先设置提现密码") }),
    /* @__PURE__ */ jsxRuntimeExports.jsx(Button, { disabled: submitIsDisabled, onClick: submit, block: true, children: trans("确认") })
  ] });
};
export {
  WithdrawSet as default
};
