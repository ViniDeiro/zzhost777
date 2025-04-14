import { q as useUserInfoStore, r as reactExports, K as jsxRuntimeExports, R as Image } from "./index-a_Ow1xUN-2024_8_30_15_11.js";
import { am as SearchToolIcon } from "./App-D9NLPZJN-2024_8_30_15_11.js";
const svg_theme_fill_color = "_svg_theme_fill_color_184g3_3";
const search_input = "_search_input_184g3_55";
const inBox = "_inBox_184g3_136";
const searchBtn = "_searchBtn_184g3_248";
const svg = "_svg_184g3_3";
const css = {
  svg_theme_fill_color,
  search_input,
  inBox,
  searchBtn,
  svg
};
const SearchInput = ({
  onInput = () => {
  },
  value,
  onBlur = () => {
  },
  onSearch = () => {
  },
  onKeyDown = () => {
  },
  placeholder,
  width,
  className
}) => {
  useUserInfoStore();
  const inputRef = reactExports.useRef();
  const handleEventInput = (e) => {
    onInput(e.target.value);
  };
  const handleClearn = (e) => {
    onInput("");
    inputRef.current.focus();
  };
  return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "".concat(css.search_input), children: /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.inBox, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsx("input", { onChange: (e) => handleEventInput(e), ref: inputRef, onBlur: (e) => {
      onBlur && onBlur(e.target.value);
    }, placeholder, value, onKeyDown }),
    /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { src: "/home/icons/close_round.webp", style: { visibility: value ? "visible" : "hidden" }, onClick: handleClearn }),
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.searchBtn, onClick: () => onSearch(), children: /* @__PURE__ */ jsxRuntimeExports.jsx(SearchToolIcon, { className: css.svg }) })
  ] }) });
};
export {
  SearchInput as S
};
