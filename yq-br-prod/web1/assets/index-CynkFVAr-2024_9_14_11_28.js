import { v as useUserInfoStore, r as reactExports, N as jsxRuntimeExports, Q as joinClass, S as Image } from "./index-CKtHrVPI-2024_9_14_11_28.js";
import { Y as useNavigateToActivity } from "./App-BLdT6wOK-2024_9_14_11_28.js";
const svg_theme_fill_color = "_svg_theme_fill_color_1n8g8_3";
const activityBottomContainer = "_activityBottomContainer_1n8g8_55";
const arrowContent = "_arrowContent_1n8g8_62";
const center = "_center_1n8g8_86";
const arrow = "_arrow_1n8g8_62";
const transform = "_transform_1n8g8_99";
const arrowColor = "_arrowColor_1n8g8_115";
const itemContainer = "_itemContainer_1n8g8_119";
const item = "_item_1n8g8_119";
const itemMap = "_itemMap_1n8g8_136";
const active = "_active_1n8g8_142";
const itemContent = "_itemContent_1n8g8_218";
const itemImg = "_itemImg_1n8g8_223";
const checked_img = "_checked_img_1n8g8_229";
const listTitle = "_listTitle_1n8g8_237";
const textActive = "_textActive_1n8g8_322";
const css = {
  svg_theme_fill_color,
  activityBottomContainer,
  arrowContent,
  center,
  arrow,
  transform,
  arrowColor,
  itemContainer,
  item,
  itemMap,
  active,
  itemContent,
  itemImg,
  checked_img,
  listTitle,
  textActive
};
const checkMaps = {
  black: "/home/icons/checkd.webp",
  blue: "/home/icons/checkd_blue.webp",
  whiteGreen: "/home/icons/checkd_white_green.webp",
  purple: "/home/icons/checkd_purple.webp",
  whiteRed: "/home/icons/checkd_white_red.webp",
  oilyGreen: "/home/icons/checkd_oily_green.webp",
  versaceYellow: "/home/icons/checkd_versaceYellow.webp",
  hermesOrange: "/home/icons/checkd_hermesOrange.webp",
  whiteBlue: "/home/icons/checkd_whiteBlue.webp",
  sk2: "/home/icons/checkd_sk2.webp",
  whiteYellow: "/home/icons/checkd_whiteYellow.webp",
  lightBrown: "/home/icons/checkd_lightBrown.webp",
  whiteOrange: "/home/icons/checkd_whiteOrange.webp",
  furlaBlue: "/home/icons/checkd_furlaBlue.webp",
  whitePink: "/home/icons/check_whitePink.webp",
  bvGreen: "/home/icons/check_bvGreen.webp",
  whiteBrown: "/home/icons/check_whiteBrown.webp",
  AnnaSuiPurple: "/home/icons/check_AnnaSuiPurple.webp",
  whitePurple: "/home/icons/check_whitePurple.webp",
  burgundyRed: "/home/icons/check_burgundyRed.webp",
  whiteDarkGreen: "/home/icons/check_whiteDarkGreen.webp",
  whiteBrownLauren: "/home/icons/check_whiteBrownLauren.webp",
  greenGold: "/home/icons/check_greenGold.webp",
  whiteRedGucci: "/home/icons/check_whiteRedGucci.webp",
  embraerBlue: "/home/icons/check_embraerBlue.webp",
  elsaPink: "/home/icons/check_elsaPink.webp",
  bvlgariBrown: "/home/icons/check_bvlgariBrown.webp",
  whiteBlack: "/home/icons/check_whiteBlack.webp"
};
const setActiveCenter = () => {
  const container = document.querySelector(".".concat(css.itemContainer));
  const item2 = document.querySelector(".".concat(css.itemMap, ".").concat(css.active));
  if (!container || !item2) {
    return;
  }
  const itemWidth = item2.clientWidth;
  const containerWidth = container.clientWidth;
  const left = item2.offsetLeft - (containerWidth - itemWidth) / 2;
  container.scrollLeft = left;
};
const ActivityBottom = () => {
  const { list, curId, handleClick, next, prev } = useNavigateToActivity();
  const { theme } = useUserInfoStore();
  reactExports.useEffect(() => {
    setActiveCenter();
  }, [curId, list]);
  return /* @__PURE__ */ jsxRuntimeExports.jsx(jsxRuntimeExports.Fragment, { children: /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.activityBottomContainer, children: /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.center, children: /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.itemContainer, children: list.map((item2, index) => {
    return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: joinClass(css.item), children: [
      /* @__PURE__ */ jsxRuntimeExports.jsxs(
        "div",
        {
          className: joinClass(
            css.itemMap,
            curId === item2.id ? css.active : ""
          ),
          children: [
            /* @__PURE__ */ jsxRuntimeExports.jsx(
              "div",
              {
                className: css.itemContent,
                onClick: (e) => {
                  e.stopPropagation();
                  handleClick(item2);
                },
                children: /* @__PURE__ */ jsxRuntimeExports.jsx(
                  Image,
                  {
                    className: css.itemImg,
                    src: item2.static.list_h5 || item2.static.list_web,
                    remote: true,
                    isGame: true
                  }
                )
              }
            ),
            curId === item2.id && /* @__PURE__ */ jsxRuntimeExports.jsx(
              Image,
              {
                className: css.checked_img,
                src: checkMaps[theme] || "/home/icons/checkd.webp"
              }
            )
          ]
        }
      ),
      /* @__PURE__ */ jsxRuntimeExports.jsx(
        "div",
        {
          className: joinClass(
            css.listTitle,
            curId === item2.id ? css.textActive : ""
          ),
          children: item2.title
        }
      )
    ] }, index);
  }) }) }) }) });
};
export {
  ActivityBottom as A
};
