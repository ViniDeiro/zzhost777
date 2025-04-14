import { D as useLocation, r as reactExports, v as useUserInfoStore, N as jsxRuntimeExports, Q as joinClass, T as trans, ab as customToFixed, S as Image, bJ as getMemberRecordTradeDetail } from "./index-CKtHrVPI-2024_9_14_11_28.js";
import { q as customFormatTimer, C as CopyText, v as mineCss } from "./App-BLdT6wOK-2024_9_14_11_28.js";
const svg_theme_fill_color = "_svg_theme_fill_color_15hkw_3";
const container = "_container_15hkw_55";
const item = "_item_15hkw_58";
const lable = "_lable_15hkw_123";
const value = "_value_15hkw_212";
const yellow = "_yellow_15hkw_318";
const red = "_red_15hkw_402";
const right = "_right_15hkw_480";
const w60 = "_w60_15hkw_486";
const green = "_green_15hkw_489";
const withItem = "_withItem_15hkw_559";
const bankIco = "_bankIco_15hkw_563";
const title = "_title_15hkw_572";
const phone = "_phone_15hkw_644";
const infoBank = "_infoBank_15hkw_718";
const white = "_white_15hkw_733";
const css = {
  svg_theme_fill_color,
  container,
  item,
  lable,
  value,
  yellow,
  red,
  right,
  w60,
  green,
  withItem,
  bankIco,
  title,
  phone,
  infoBank,
  white
};
const formatStr = (str) => {
  if (!str)
    return "";
  const len = str.length;
  if (len < 4)
    return str;
  const end = str.substr(len - 4, 4);
  return "****".concat(end);
};
const WithdrawDetail = () => {
  var _a, _b, _c, _d;
  const location = useLocation();
  const query = new URLSearchParams(location.search);
  const id = query.get("id");
  const [detail, setDetail] = reactExports.useState({});
  const { info } = useUserInfoStore();
  const getDetail = async () => {
    const [res, err] = await getMemberRecordTradeDetail({
      id,
      flag: 272
    });
    if (err)
      return;
    if (res.d === null)
      return;
    setDetail(res.d[0]);
  };
  const userInfo = reactExports.useMemo(() => {
    if (!info) {
      return {
        username: "",
        uid: ""
      };
    }
    return {
      username: info.username,
      uid: info.uid
    };
  }, [info]);
  const stateToText = (state) => {
    switch (state) {
      case 371:
        return trans("正在审查中");
      case 372:
        return trans("审核拒绝");
      case 373:
        return trans("拉出来");
      case 374:
        return trans("提款成功");
      case 375:
        return trans("提现失败");
      case 376:
        return trans("订单异常");
      case 377:
        return trans("支付失败");
      case 381:
        return trans("取消");
      default:
        return trans("未知");
    }
  };
  reactExports.useEffect(() => {
    getDetail();
  }, []);
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.container, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: joinClass(css.item, mineCss.flexItemCenter), children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.lable, children: trans("创建时间") }),
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.value, children: detail.created_at == "0" ? "" : customFormatTimer(detail.created_at) })
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: joinClass(css.item, mineCss.flexItemCenter), children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.lable, children: trans("提款金额") }),
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: joinClass(css.value, css.yellow), children: customToFixed((_a = detail.amount) != null ? _a : 0) })
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: joinClass(css.item, mineCss.flexItemCenter), children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.lable, children: trans("手续费") }),
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: joinClass(css.value, css.yellow), children: customToFixed((_b = detail.discount) != null ? _b : 0) })
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: joinClass(css.item, mineCss.flexItemCenter), children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.lable, children: trans("到账金额") }),
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: joinClass(css.value, css.yellow), children: customToFixed((_c = detail.ramount) != null ? _c : 0) })
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: joinClass(css.item, mineCss.flexItemCenter), children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.lable, children: trans("提款方式") }),
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.value, children: detail.channel_name })
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: joinClass(css.item, mineCss.flexItemCenter), children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.lable, children: trans("账户信息") }),
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.infoBank, children: /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.withItem, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { className: css.bankIco, src: "/home/icons/deposit_".concat((_d = detail.channel_name) == null ? void 0 : _d.toLocaleLowerCase(), ".webp") }),
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.right, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.title, children: userInfo.username }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.phone, children: formatStr(detail.account) })
        ] })
      ] }) })
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: joinClass(css.item, mineCss.flexItemCenter), children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.lable, children: trans("审核状态") }),
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.w60, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: joinClass(css.value, detail.state === 372 || detail.state === 375 ? css.red : css.green), children: stateToText(detail.state) }),
        detail.state !== 374 ? /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: joinClass(css.lable, css.right, detail.state === 372 || detail.state === 375 ? css.red : css.green), dangerouslySetInnerHTML: {
          __html: detail.remark
        } }) : ""
      ] })
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: joinClass(css.item, mineCss.flexItemCenter), children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.lable, children: trans("审核时间") }),
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.value, children: detail.updated_at + "" === "0" ? "" : customFormatTimer(detail.updated_at) })
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: joinClass(css.item, mineCss.flexItemCenter), children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.lable, children: trans("订单号") }),
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.value, children: /* @__PURE__ */ jsxRuntimeExports.jsx(CopyText, { value: detail.bill_no, className: css.white }) })
    ] })
  ] });
};
export {
  WithdrawDetail as default
};
