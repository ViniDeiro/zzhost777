import { v as useUserInfoStore, A as useNavigate, r as reactExports, N as jsxRuntimeExports, Q as joinClass, S as Image, ab as customToFixed, bV as currentUnitConfig, W as Modal, a9 as Message, bL as getPromoWelfareApply, w as browser, am as getMemberBankcardList } from "./index-CKtHrVPI-2024_9_14_11_28.js";
import { l as useTranslation, b as Guide } from "./App-BLdT6wOK-2024_9_14_11_28.js";
const svg_theme_fill_color = "_svg_theme_fill_color_lblkv_3";
const missao_container = "_missao_container_lblkv_55";
const left_nav = "_left_nav_lblkv_59";
const left_nav_item = "_left_nav_item_lblkv_62";
const left_nav_button = "_left_nav_button_lblkv_194";
const rightContainer = "_rightContainer_lblkv_321";
const rightItem = "_rightItem_lblkv_327";
const missao_title_box = "_missao_title_box_lblkv_427";
const missao_bonus = "_missao_bonus_lblkv_481";
const missao_bonus_label = "_missao_bonus_label_lblkv_484";
const missao_bonus_val = "_missao_bonus_val_lblkv_487";
const btn = "_btn_lblkv_659";
const oper_btn = "_oper_btn_lblkv_659";
const bonus_btn = "_bonus_btn_lblkv_659";
const rule_details = "_rule_details_lblkv_809";
const rule_title = "_rule_title_lblkv_816";
const rule_context = "_rule_context_lblkv_819";
const noBankTip = "_noBankTip_lblkv_1066";
const tip_context = "_tip_context_lblkv_1137";
const noBankTip_btns = "_noBankTip_btns_lblkv_1177";
const cancel = "_cancel_lblkv_1198";
const sure = "_sure_lblkv_1202";
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
    if (!!item["check_deposit"] && item["first_deposit_done"] !== 1)
      return Message.error(t("请完成首次充值，即可领取彩金"));
    if (!token)
      return useUserInfoStore.setState({ openForRegister: true });
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
      return useUserInfoStore.setState({ openForRegister: true });
    }
    if (item.welfare_id === "1") {
      window.open(appUrl, "_blank");
    } else if (item.welfare_id === "2") {
      if (browser.versions.mobile) {
        guideRef.current.saveToDesktop();
      } else {
        console.error("浏览器不支持!");
      }
    } else {
      if (!!isSetWithdrawPassword) {
        const linkList = {
          "3": "/withdraw",
          "4": "/personal-information",
          "5": "/withdraw",
          "6": "/withdraw",
          "7": "/personal-information",
          "8": "/personal-information"
        };
        navigate(linkList[item == null ? void 0 : item.welfare_id]);
      } else {
        const linkList = {
          "3": "/withdraw-set",
          "4": "/personal-information",
          "5": "/withdraw-set",
          "6": "/withdraw-set",
          "7": "/personal-information",
          "8": "/personal-information"
        };
        navigate(linkList[item == null ? void 0 : item.welfare_id]);
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
            t("任务规则_1", { utc: currentUnitConfig["utc"] })
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
