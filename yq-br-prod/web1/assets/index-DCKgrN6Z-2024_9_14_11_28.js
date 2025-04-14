import { N as jsxRuntimeExports, Q as joinClass, S as Image, T as trans } from "./index-CKtHrVPI-2024_9_14_11_28.js";
const svg_theme_fill_color = "_svg_theme_fill_color_vutuo_3";
const maintainBox = "_maintainBox_vutuo_55";
const img = "_img_vutuo_68";
const span = "_span_vutuo_73";
const css = {
  svg_theme_fill_color,
  maintainBox,
  img,
  span
};
const Maintain = ({ className } = {}) => {
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: joinClass(css.maintainBox, className), onClick: (e) => {
    e.stopPropagation();
  }, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { className: css.img, src: "/home/icons/maintain.webp" }),
    /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: css.span, children: trans("Maintenance") })
  ] });
};
export {
  Maintain as M
};
