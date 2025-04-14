import { q as useUserInfoStore, x as useNavigate, r as reactExports, K as jsxRuntimeExports, P as joinClass, R as Image, aa as customToFixed, a7 as Message, bI as getPromoWelfareApply, s as browser, ak as getMemberBankcardList } from "./index-a_Ow1xUN-2024_8_30_15_11.js";
import { l as useTranslation, b as Guide, M as Modal } from "./App-D9NLPZJN-2024_8_30_15_11.js";
const svg_theme_fill_color = "_svg_theme_fill_color_1ovjr_3";
const missao_container = "_missao_container_1ovjr_55";
const left_nav = "_left_nav_1ovjr_59";
const left_nav_item = "_left_nav_item_1ovjr_62";
const left_nav_button = "_left_nav_button_1ovjr_170";
const rightContainer = "_rightContainer_1ovjr_273";
const rightItem = "_rightItem_1ovjr_279";
const missao_title_box = "_missao_title_box_1ovjr_358";
const missao_bonus = "_missao_bonus_1ovjr_397";
const missao_bonus_label = "_missao_bonus_label_1ovjr_400";
const missao_bonus_val = "_missao_bonus_val_1ovjr_403";
const btn = "_btn_1ovjr_539";
const oper_btn = "_oper_btn_1ovjr_539";
const bonus_btn = "_bonus_btn_1ovjr_539";
const rule_details = "_rule_details_1ovjr_648";
const rule_title = "_rule_title_1ovjr_655";
const rule_context = "_rule_context_1ovjr_658";
const noBankTip = "_noBankTip_1ovjr_851";
const tip_context = "_tip_context_1ovjr_910";
const noBankTip_btns = "_noBankTip_btns_1ovjr_941";
const cancel = "_cancel_1ovjr_962";
const sure = "_sure_1ovjr_966";
const css = {
  svg_theme_fill_color,
  missao_container,
  left_nav,
  left_nav_item,
  left_nav_button,
  rightContainer,
  rightItem,
  missao_title_box,
  missao_bonus,
  missao_bonus_label,
  missao_bonus_val,
  btn,
  oper_btn,
  bonus_btn,
  rule_details,
  rule_title,
  rule_context,
  noBankTip,
  tip_context,
  noBankTip_btns,
  cancel,
  sure
};
const Missao = () => {
  const { t } = useTranslation();
  const {
    // info,
    // theme,
    token,
    missaoList,
    getMissaoList,
    getAvailableList,
    appUrl,
    isSetWithdrawPassword
  } = useUserInfoStore();
  const navigate = useNavigate();
  const guideRef = reactExports.useRef();
  const [hasBank, setHasBank] = reactExports.useState(false);
  const [showBankPop, setShowBankPop] = reactExports.useState(false);
  const handleGetBonus = (item) => {
    if (item.first_deposit_done !== 1) {
      Message.success(t("请完成首次充值，即可领取彩金"));
      return;
    }
    if (!token) {
      useUserInfoStore.setState({ openForRegister: true });
      return;
    }
    getPromoWelfareApply({ id: item.id }).then(([res, err]) => {
      if (res == "1346") {
        setShowBankPop(true);
        return;
      }
      if (res) {
        Message.success(t("成功收到") + "~");
        getMissaoList();
        getAvailableList({ state: "502" });
      }
    });
  };
  const handleOper = (item) => {
    if (!token) {
      useUserInfoStore.setState({ openForRegister: true });
      return;
    }
    if (item.welfare_id === "1") {
      window.open(appUrl, "_blank");
    } else if (item.welfare_id === "2") {
      if (browser.versions.mobile) {
        guideRef.current.saveToDesktop();
      } else {
        console.error("浏览器不支持!");
      }
    }
  };
  const getBankcardList = async () => {
    var _a;
    const bankResult = await getMemberBankcardList();
    bankResult[0] && ((_a = bankResult[0]) == null ? void 0 : _a.length) > 0 && setHasBank(true);
  };
  reactExports.useEffect(() => {
    getMissaoList();
    if (token) {
      getBankcardList();
    }
  }, []);
  return /* @__PURE__ */ jsxRuntimeExports.jsxs(jsxRuntimeExports.Fragment, { children: [
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.missao_container, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.left_nav, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: joinClass(css.left_nav_item), children: /* @__PURE__ */ jsxRuntimeExports.jsxs("span", { children: [
          " ",
          t("新玩家的福利")
        ] }) }),
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          "div",
          {
            className: joinClass(css.left_nav_button, "button"),
            onClick: () => {
              console.log("token :", token);
              if (!token) {
                useUserInfoStore.setState({ openForRegister: true });
                return;
              }
              navigate("/alreadyGetbonus?flag=279");
            },
            children: t("历史记录")
          }
        )
      ] }),
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.rightContainer, children: [
        missaoList.map((item, index) => /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.rightItem, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.rightItem_info, children: [
            /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.missao_title_box, children: [
              /* @__PURE__ */ jsxRuntimeExports.jsx(
                Image,
                {
                  className: css.iconImg,
                  src: "/home/icons/".concat(item.icon)
                }
              ),
              /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: item.title })
            ] }),
            /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.missao_bonus, children: [
              /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: css.missao_bonus_label, children: t("奖金") }),
              /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: css.missao_bonus_val, children: customToFixed(item.amount) })
            ] })
          ] }),
          item.state === 501 ? /* @__PURE__ */ jsxRuntimeExports.jsx(
            "button",
            {
              className: joinClass(css.oper_btn, "button"),
              onClick: () => {
                handleOper(item);
              },
              children: t("待领取")
            }
          ) : /* @__PURE__ */ jsxRuntimeExports.jsx(
            "button",
            {
              className: joinClass(css.bonus_btn, "button"),
              disabled: item.state !== 502,
              onClick: () => {
                handleGetBonus(item);
              },
              children: item.state === 502 ? t("领取") : t("已结算")
            }
          )
        ] }, index)),
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.rule_details, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsxs("p", { className: css.rule_title, children: [
            " ",
            t("任务规则_1")
          ] }),
          /* @__PURE__ */ jsxRuntimeExports.jsxs("span", { className: css.rule_context, children: [
            " ",
            t("任务规则_2")
          ] }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("p", { className: css.rule_title, children: t("任务规则_3") }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: css.rule_context, children: t("任务规则_4") }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("p", { className: css.rule_title, children: t("任务规则_5") }),
          /* @__PURE__ */ jsxRuntimeExports.jsxs("span", { className: css.rule_context, children: [
            t("任务规则_6"),
            /* @__PURE__ */ jsxRuntimeExports.jsx("br", {}),
            t("任务规则_7"),
            /* @__PURE__ */ jsxRuntimeExports.jsx("br", {}),
            t("任务规则_8"),
            /* @__PURE__ */ jsxRuntimeExports.jsx("br", {}),
            t("任务规则_9"),
            /* @__PURE__ */ jsxRuntimeExports.jsx("br", {}),
            t("任务规则_10"),
            /* @__PURE__ */ jsxRuntimeExports.jsx("br", {}),
            t("任务规则_11")
          ] })
        ] })
      ] })
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsx(Guide, { openPop: false, openGuide: false, event: guideRef }),
    /* @__PURE__ */ jsxRuntimeExports.jsx(Modal, { isOpen: showBankPop, children: /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.noBankTip, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.tip_context, children: t("您需要先链接付款方式才能收到") }),
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.noBankTip_btns, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          "button",
          {
            className: joinClass(css.cancel, "button"),
            onClick: () => {
              setShowBankPop(false);
            },
            children: t("取消")
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
            children: t("继续")
          }
        )
      ] })
    ] }) })
  ] });
};
export {
  Missao as default
};
