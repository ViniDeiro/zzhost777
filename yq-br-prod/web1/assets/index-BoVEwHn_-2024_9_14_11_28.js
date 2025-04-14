import { N as jsxRuntimeExports } from "./index-CKtHrVPI-2024_9_14_11_28.js";
import { u as useFlutterApp, H as HomeBars } from "./App-BLdT6wOK-2024_9_14_11_28.js";
const svg_theme_fill_color = "_svg_theme_fill_color_1hekq_3";
const container = "_container_1hekq_55";
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
