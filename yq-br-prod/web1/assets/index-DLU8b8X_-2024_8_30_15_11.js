import { K as jsxRuntimeExports } from "./index-a_Ow1xUN-2024_8_30_15_11.js";
import { u as useFlutterApp, H as HomeBars } from "./App-D9NLPZJN-2024_8_30_15_11.js";
const svg_theme_fill_color = "_svg_theme_fill_color_17c6r_3";
const container = "_container_17c6r_55";
const css = {
  svg_theme_fill_color,
  container
};
const Index = ({ children }) => {
  const { isApp } = useFlutterApp();
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.container, children: [
    children,
    !isApp && /* @__PURE__ */ jsxRuntimeExports.jsx(HomeBars, {})
  ] });
};
export {
  Index as default
};
