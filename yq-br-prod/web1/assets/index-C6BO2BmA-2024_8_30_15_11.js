import { q as useUserInfoStore, r as reactExports, x as useNavigate, K as jsxRuntimeExports, E as getMoneyUnit, aa as customToFixed, S as trans, P as joinClass, bI as getPromoWelfareApply, a7 as Message, ak as getMemberBankcardList } from "./index-a_Ow1xUN-2024_8_30_15_11.js";
import { aa as Empty, p as customFormatTimer, M as Modal } from "./App-D9NLPZJN-2024_8_30_15_11.js";
const svg_theme_fill_color$1 = "_svg_theme_fill_color_1m2wm_3";
const bonus = "_bonus_1m2wm_55";
const header = "_header_1m2wm_55";
const moneyLabel = "_moneyLabel_1m2wm_61";
const totalMoney = "_totalMoney_1m2wm_123";
const normalBtn = "_normalBtn_1m2wm_182";
const bonusTableBox = "_bonusTableBox_1m2wm_219";
const css$1 = {
  svg_theme_fill_color: svg_theme_fill_color$1,
  bonus,
  header,
  moneyLabel,
  totalMoney,
  normalBtn,
  bonusTableBox
};
const svg_theme_fill_color = "_svg_theme_fill_color_1a53q_3";
const alreadyGetbonus_list = "_alreadyGetbonus_list_1a53q_55";
const noBankTip = "_noBankTip_1a53q_609";
const tip_context = "_tip_context_1a53q_674";
const noBankTip_btns = "_noBankTip_btns_1a53q_711";
const cancel = "_cancel_1a53q_732";
const sure = "_sure_1a53q_736";
const css = {
  svg_theme_fill_color,
  alreadyGetbonus_list,
  noBankTip,
  tip_context,
  noBankTip_btns,
  cancel,
  sure
};
const List = () => {
  const { token, availableList, getAvailableList, isSetWithdrawPassword, getMissaoList } = useUserInfoStore();
  const [hasBank, setHasBank] = reactExports.useState(false);
  const [showBankPop, setShowBankPop] = reactExports.useState(false);
  const navigate = useNavigate();
  const params = {
    state: "502"
  };
  const data = availableList.d || [];
  const handleGetBonus = (item) => {
    if (!token) {
      useUserInfoStore.setState({ openForRegister: true });
      return;
    }
    getPromoWelfareApply({ id: item.id }).then(([res, , err]) => {
      if (res == "1346") {
        setShowBankPop(true);
        return;
      }
      if (res) {
        Message.success("Recebido com sucesso~");
        getAvailableList(params);
        getMissaoList();
      }
    });
  };
  const getBankcardList = async () => {
    var _a;
    const bankResult = await getMemberBankcardList();
    bankResult[0] && ((_a = bankResult[0]) == null ? void 0 : _a.length) > 0 && setHasBank(true);
  };
  reactExports.useEffect(() => {
    if (token) {
      getBankcardList();
      getAvailableList(params);
    }
  }, []);
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.alreadyGetbonus_list, children: [
    data.length === 0 ? /* @__PURE__ */ jsxRuntimeExports.jsx(Empty, { type: 2 }) : data.map((item, index) => {
      return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: "alreadyGetbonus_list_row", children: [
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: "context_box", children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "title", children: item.title }),
          /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: "alreadyGetbonus_list__container", children: [
            /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: "alreadyGetbonus_list_bonus", children: [
              /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: "alreadyGetbonus_list_RS", children: getMoneyUnit(true) }),
              /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: "bonus", children: customToFixed(item.amount) })
            ] }),
            /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "alreadyGetbonus_list_date", children: customFormatTimer(item.created_at * 1e3, "DD/MM/YYYY") }),
            /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: "alreadyGetbonus_list_status", children: [
              /* @__PURE__ */ jsxRuntimeExports.jsxs("span", { children: [
                trans("来源"),
                ": "
              ] }),
              /* @__PURE__ */ jsxRuntimeExports.jsx("span", { children: trans("任务奖励") })
            ] })
          ] })
        ] }),
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          "div",
          {
            className: "alreadyGetbonus_list_btn",
            onClick: () => {
              handleGetBonus(item);
            },
            children: trans("领取")
          }
        )
      ] }, index);
    }),
    /* @__PURE__ */ jsxRuntimeExports.jsx(Modal, { isOpen: showBankPop, children: /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.noBankTip, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.tip_context, children: "Você precisa vincular a forma de pagamento antes de recebê-lo!" }),
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.noBankTip_btns, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          "button",
          {
            className: joinClass(css.cancel, "button"),
            onClick: () => {
              setShowBankPop(false);
            },
            children: "Cancelar"
          }
        ),
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          "button",
          {
            className: joinClass(css.sure, "button"),
            onClick: () => {
              if (isSetWithdrawPassword) {
                navigate("/withdraw");
              } else {
                navigate("/withdraw-set?to=withdraw");
              }
            },
            children: "Continuar"
          }
        )
      ] })
    ] }) })
  ] });
};
const Bonus = () => {
  const { availableList } = useUserInfoStore();
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.bonus, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$1.header, children: /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.totalMoney, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: css$1.moneyLabel, children: trans("奖金") }),
      /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: css$1.totalMoney, children: customToFixed(availableList.agg) })
    ] }) }),
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$1.bonusTableBox, children: /* @__PURE__ */ jsxRuntimeExports.jsx(List, {}) })
  ] });
};
export {
  Bonus as default
};
