import { K as jsxRuntimeExports, R as Image, x as useNavigate, aa as customToFixed, r as reactExports, P as joinClass, q as useUserInfoStore, bq as getVipConfig } from "./index-a_Ow1xUN-2024_8_30_15_11.js";
import { l as useTranslation } from "./App-D9NLPZJN-2024_8_30_15_11.js";
const svg_theme_fill_color$1 = "_svg_theme_fill_color_1rhy2_3";
const vip_icon = "_vip_icon_1rhy2_55";
const css$1 = {
  svg_theme_fill_color: svg_theme_fill_color$1,
  vip_icon
};
const VipIcon = ({ level, className, type = "" }) => {
  return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "".concat(css$1.vip_icon, " ").concat(!!className && className), children: /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { src: "/home/vip/vip".concat(level).concat(type ? "_".concat(type) : "", ".webp") }) });
};
const svg_theme_fill_color = "_svg_theme_fill_color_1ht59_3";
const vip_page = "_vip_page_1ht59_55";
const flex = "_flex_1ht59_205";
const flex1 = "_flex1_1ht59_209";
const flexCenter = "_flexCenter_1ht59_213";
const vipProgressContainer = "_vipProgressContainer_1ht59_219";
const progressTitle = "_progressTitle_1ht59_308";
const vipProgress = "_vipProgress_1ht59_219";
const vipImg = "_vipImg_1ht59_478";
const ico = "_ico_1ht59_478";
const progressWidth = "_progressWidth_1ht59_482";
const progressContent = "_progressContent_1ht59_485";
const progress = "_progress_1ht59_308";
const title1 = "_title1_1ht59_492";
const special = "_special_1ht59_492";
const title2 = "_title2_1ht59_556";
const vipleftspan = "_vipleftspan_1ht59_620";
const vipTip = "_vipTip_1ht59_695";
const nextMoney = "_nextMoney_1ht59_739";
const progressComponent = "_progressComponent_1ht59_750";
const content = "_content_1ht59_847";
const c_list = "_c_list_1ht59_974";
const fullLevel = "_fullLevel_1ht59_1478";
const tips = "_tips_1ht59_1537";
const amount = "_amount_1ht59_1571";
const bestImg = "_bestImg_1ht59_1601";
const bestContent = "_bestContent_1ht59_1605";
const css = {
  svg_theme_fill_color,
  vip_page,
  flex,
  flex1,
  flexCenter,
  vipProgressContainer,
  progressTitle,
  vipProgress,
  vipImg,
  ico,
  progressWidth,
  progressContent,
  progress,
  title1,
  special,
  title2,
  vipleftspan,
  vipTip,
  nextMoney,
  progressComponent,
  content,
  c_list,
  fullLevel,
  tips,
  amount,
  bestImg,
  bestContent
};
const VipProgress = () => {
  const { t, i18n } = useTranslation();
  const { info } = useUserInfoStore();
  const propgressNum = reactExports.useMemo(() => {
    return (info == null ? void 0 : info.now) / (info == null ? void 0 : info.next) * 100;
  }, [info]);
  return /* @__PURE__ */ jsxRuntimeExports.jsxs(
    "section",
    {
      className: joinClass(
        css.vipProgressContainer,
        (info == null ? void 0 : info.level) == 15 ? css.bestContent : ""
      ),
      children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.progressTitle, children: t("当前水平") }),
        /* @__PURE__ */ jsxRuntimeExports.jsxs(
          "div",
          {
            className: joinClass(
              css.vipProgress,
              (info == null ? void 0 : info.level) != 15 ? css.flexCenter : ""
            ),
            children: [
              (info == null ? void 0 : info.level) != 15 ? /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.vipImg, children: /* @__PURE__ */ jsxRuntimeExports.jsx(VipIcon, { level: info == null ? void 0 : info.level }) }) : /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { src: "/home/vip/vip_best.webp", className: css.bestImg }),
              (info == null ? void 0 : info.level) != 15 ? /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.progressWidth, children: /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: joinClass(css.progressContent, css.flex1), children: [
                /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: joinClass(css.title1, css.flexCenter), children: [
                  /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: css.vipleftspan, children: t("下一个等级") }),
                  /* @__PURE__ */ jsxRuntimeExports.jsxs("span", { className: joinClass(css.special, css.vipTip), children: [
                    "VIP",
                    info == null ? void 0 : info.next_level
                  ] })
                ] }),
                /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.progress, children: /* @__PURE__ */ jsxRuntimeExports.jsx(
                  Progress,
                  {
                    progress: propgressNum,
                    text: info == null ? void 0 : info.now,
                    next: info == null ? void 0 : info.next
                  }
                ) }),
                /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: joinClass(css.title2, css.flexCenter), children: [
                  /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: joinClass(css.vipleftspan), children: t("仍需有效投注") }),
                  /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: joinClass(css.special, css.nextMoney), children: customToFixed((info == null ? void 0 : info.next) - (info == null ? void 0 : info.now)) })
                ] })
              ] }) }) : /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.fullLevel, children: [
                /* @__PURE__ */ jsxRuntimeExports.jsxs("p", { children: [
                  t("累计有效投注"),
                  /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: css.amount, children: customToFixed(info == null ? void 0 : info.now) })
                ] }),
                /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: css.tips, children: t("恭喜您，您已达到最高等级！") })
              ] }),
              (info == null ? void 0 : info.level) != 15 ? /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.vipImg, children: /* @__PURE__ */ jsxRuntimeExports.jsx(VipIcon, { level: info == null ? void 0 : info.next_level }) }) : /* @__PURE__ */ jsxRuntimeExports.jsx("div", {})
            ]
          }
        )
      ]
    }
  );
};
const Progress = ({ progress: progress2 = 0, text = "0", next = "0" }) => {
  return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.progressComponent, children: /* @__PURE__ */ jsxRuntimeExports.jsx(
    "div",
    {
      className: css.content,
      style: { width: "".concat(Math.min(progress2, 100), "%") },
      children: /* @__PURE__ */ jsxRuntimeExports.jsxs("span", { children: [
        +text && customToFixed(text),
        " / ",
        +next && customToFixed(next)
      ] })
    }
  ) });
};
const VipList = ({ colums = [], data = [] }) => {
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.c_list, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "c_list_header c_list_row", children: colums.map((col) => {
      return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "c_list_col", children: col.title }, col.field);
    }) }),
    data.map((row, index) => {
      return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "c_list_row", children: colums.map((col, i) => {
        return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "c_list_col", children: col.render ? col.render(row) : col.format ? col.format(row) : row[col["field"]] }, i);
      }) }, index);
    })
  ] });
};
const Vip = () => {
  const { t, i18n } = useTranslation();
  const navigate = useNavigate();
  const colums = [
    {
      title: t("等级"),
      field: "level",
      render: (row) => {
        return /* @__PURE__ */ jsxRuntimeExports.jsx(VipIcon, { level: row.level });
      }
    },
    {
      title: t("有效投注"),
      field: "upgrade_record",
      format: (row) => {
        return customToFixed(row.upgrade_record);
      }
    },
    {
      title: t("奖金"),
      field: "upgrade_gift",
      format: (row) => customToFixed(row.upgrade_gift)
    }
  ];
  const [data, setData] = reactExports.useState([]);
  const getConfig = async () => {
    const [res] = await getVipConfig();
    setData(res);
  };
  reactExports.useEffect(() => {
    getConfig();
  }, []);
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.vip_page, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsx(VipProgress, {}),
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "btns", children: /* @__PURE__ */ jsxRuntimeExports.jsx(
      "div",
      {
        className: joinClass("button", css.flexCenter),
        onClick: () => navigate("/deposit"),
        children: t("立即充值")
      }
    ) }),
    /* @__PURE__ */ jsxRuntimeExports.jsx("h5", { children: t("VIP等级列表") }),
    /* @__PURE__ */ jsxRuntimeExports.jsx(VipList, { colums, data })
  ] });
};
export {
  Vip as default
};
