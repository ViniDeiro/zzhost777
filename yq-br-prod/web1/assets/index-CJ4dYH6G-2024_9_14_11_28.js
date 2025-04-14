import { v as useUserInfoStore, r as reactExports, N as jsxRuntimeExports } from "./index-CKtHrVPI-2024_9_14_11_28.js";
import { w as InputClearIcon, S as SearchToolIcon } from "./App-BLdT6wOK-2024_9_14_11_28.js";
const svg_theme_fill_color = "_svg_theme_fill_color_uk8fc_3";
const search_input = "_search_input_uk8fc_55";
const inBox = "_inBox_uk8fc_151";
const searchBtn = "_searchBtn_uk8fc_367";
const svg = "_svg_uk8fc_3";
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
    value ? /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.clsoeBtn, onClick: handleClearn, children: /* @__PURE__ */ jsxRuntimeExports.jsx(InputClearIcon, { className: css.iconsvg }) }) : "",
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.searchBtn, onClick: () => onSearch(), children: /* @__PURE__ */ jsxRuntimeExports.jsx(SearchToolIcon, { className: css.svg }) })
  ] }) });
};
export {
  SearchInput as S
};
