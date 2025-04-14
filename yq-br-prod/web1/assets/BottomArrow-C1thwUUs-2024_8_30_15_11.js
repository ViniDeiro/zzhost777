import { K as jsxRuntimeExports, P as joinClass } from "./index-a_Ow1xUN-2024_8_30_15_11.js";
const BottomArrowIcon = ({ className, classColor } = {}) => {
  return /* @__PURE__ */ jsxRuntimeExports.jsxs(
    "svg",
    {
      className: joinClass(className),
      width: "32",
      height: "32",
      viewBox: "0 0 32 32",
      fill: "none",
      xmlns: "http://www.w3.org/2000/svg",
      children: [
        /* @__PURE__ */ jsxRuntimeExports.jsxs("g", { clipPath: "url(#clip0_931_156495)", children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("rect", { width: "32", height: "32", rx: "16", fill: "black", fillOpacity: "0.05" }),
          /* @__PURE__ */ jsxRuntimeExports.jsx(
            "rect",
            {
              x: "0.5",
              y: "0.5",
              width: "31",
              height: "31",
              rx: "15.5",
              stroke: "white",
              strokeOpacity: "0.3"
            }
          ),
          /* @__PURE__ */ jsxRuntimeExports.jsx(
            "path",
            {
              d: "M19 9L12 16L19 23",
              stroke: classColor || "#FFDC82",
              strokeWidth: "1.75",
              strokeLinecap: "round"
            }
          )
        ] }),
        /* @__PURE__ */ jsxRuntimeExports.jsx("defs", { children: /* @__PURE__ */ jsxRuntimeExports.jsx("clipPath", { id: "clip0_931_156495", children: /* @__PURE__ */ jsxRuntimeExports.jsx("rect", { width: "32", height: "32", rx: "8", fill: "white" }) }) })
      ]
    }
  );
};
export {
  BottomArrowIcon,
  BottomArrowIcon as default
};
