import { r as reactExports, N as jsxRuntimeExports, Q as joinClass, V as css$7, al as events, T as trans, a9 as Message$1, A as useNavigate, F as useMessageStore, v as useUserInfoStore, J as Cache, bz as readUserMessage, S as Image, P as useReactive, b8 as getNoticeList, O as getMemberCustomerList, bA as withdrawFeedback, bB as listFeedback, bC as addFeedback, bD as getMessageList, bE as deleteUserMessage } from "./index-CKtHrVPI-2024_9_14_11_28.js";
import { l as useTranslation, m as ArrowLeftInMineIcon, w as InputClearIcon, E as Empty, q as customFormatTimer, d as useAsyncEffect, B as Button, i as clipboardExports, R as RectCopyIcon, h as LoadMore } from "./App-BLdT6wOK-2024_9_14_11_28.js";
import { S as Spin } from "./index-DJXr1s84-2024_9_14_11_28.js";
import { S as S3PutObject } from "./s3-BB0I09dN-2024_9_14_11_28.js";
const SvgIcon$3 = (props) => /* @__PURE__ */ reactExports.createElement("svg", { width: 24, height: 24, viewBox: "0 0 24 24", fill: "none", xmlns: "http://www.w3.org/2000/svg", ...props }, /* @__PURE__ */ reactExports.createElement("path", { fillRule: "evenodd", clipRule: "evenodd", d: "M2.92935 5.99857H11.9869L11.988 5.99952H21.0456C21.0668 5.99952 21.088 5.99964 21.1093 5.99976C21.2003 6.00027 21.2915 6.00079 21.3815 5.99187C21.6833 5.96128 21.9195 5.79541 21.9677 5.54636C22.1797 4.4474 21.3243 3.58554 20.1784 3.58601C20.0509 3.5861 19.9234 3.58622 19.7959 3.58634C19.2223 3.58687 18.6486 3.5874 18.075 3.58506C17.7375 3.58382 17.5994 3.59971 17.5434 3.53938C17.4915 3.48349 17.51 3.3622 17.5057 3.1013C17.4877 1.98274 16.4018 1.01763 15.1078 1.00855C13.1519 0.994523 11.1954 1.00061 9.23951 1.0067L9.10663 1.00711C8.56423 1.00855 8.08522 1.18541 7.6651 1.4727C6.97967 1.94259 6.69641 2.56975 6.71997 3.30351C6.72726 3.52292 6.64256 3.59318 6.38398 3.58936C5.65404 3.57887 4.92324 3.58164 4.19271 3.58442C4.0913 3.5848 3.9899 3.58519 3.8885 3.58554C2.78183 3.58936 2.00778 4.25285 2.00105 5.19932C1.99656 5.81453 2.21026 5.99857 2.92935 5.99857ZM13.4739 3.58506H12.1008C11.7909 3.58506 11.4811 3.58462 11.1712 3.58418C10.3133 3.58297 9.45544 3.58176 8.59789 3.58984C8.32192 3.59223 8.24732 3.51049 8.25237 3.28582C8.26639 2.64097 8.63378 2.31688 9.39213 2.31688C11.2229 2.31544 13.0537 2.31497 14.8845 2.31688C15.6412 2.31736 16.1068 2.81497 15.9632 3.45073C15.932 3.58804 15.8298 3.58631 15.724 3.58451C15.7119 3.58431 15.6998 3.5841 15.6878 3.5841C15.0973 3.58525 14.5071 3.58517 13.9167 3.5851C13.7691 3.58508 13.6215 3.58506 13.4739 3.58506Z", fill: "#FDD981" }), /* @__PURE__ */ reactExports.createElement("path", { d: "M5.5 20V7H3.5V20C3.5 21.6569 4.84315 23 6.5 23H17.5C19.1569 23 20.5 21.6569 20.5 20V7H18.5V20C18.5 20.5523 18.0523 21 17.5 21H6.5C5.94772 21 5.5 20.5523 5.5 20Z", fill: "#FDD981" }), /* @__PURE__ */ reactExports.createElement("path", { d: "M10.5 11C10.5 10.4477 10.0523 10 9.5 10C8.94772 10 8.5 10.4477 8.5 11L8.5 18C8.5 18.5523 8.94771 19 9.5 19C10.0523 19 10.5 18.5523 10.5 18V11Z", fill: "#FDD981" }), /* @__PURE__ */ reactExports.createElement("path", { d: "M14.5 10C15.0523 10 15.5 10.4477 15.5 11V18C15.5 18.5523 15.0523 19 14.5 19C13.9477 19 13.5 18.5523 13.5 18V11C13.5 10.4477 13.9477 10 14.5 10Z", fill: "#FDD981" }));
const DeleteIcon = ({ className } = {}) => {
  return /* @__PURE__ */ jsxRuntimeExports.jsx(SvgIcon$3, { className: joinClass(css$7.defaultCss, className) });
};
const SvgIcon$2 = (props) => /* @__PURE__ */ reactExports.createElement("svg", { width: 24, height: 24, viewBox: "0 0 24 24", fill: "none", xmlns: "http://www.w3.org/2000/svg", ...props }, /* @__PURE__ */ reactExports.createElement("path", { fillRule: "evenodd", clipRule: "evenodd", d: "M18.312 8.44971C15.4301 8.44971 12.9444 10.1458 11.7986 12.5942C10.9726 12.9007 10.036 12.795 9.29143 12.2846L8.47636 11.726L2.93917 16.3732C3.07397 16.4537 3.23158 16.5 3.4 16.5H11.1758C11.2379 17.019 11.3553 17.521 11.5219 18H3.4C2.07452 18 1 16.9255 1 15.6V4.4C1 3.07452 2.07452 2 3.4 2H18.6C19.9255 2 21 3.07452 21 4.4V8.9692C20.5232 8.77682 20.0211 8.6341 19.5 8.54743V7.9236L18.6323 8.45672C18.5262 8.45206 18.4194 8.44971 18.312 8.44971ZM19.5 6.16307L11.4958 11.0812C11.0767 11.3387 10.5452 11.3255 10.1394 11.0473L2.5 5.81142V4.4C2.5 3.90294 2.90294 3.5 3.4 3.5H18.6C19.0971 3.5 19.5 3.90294 19.5 4.4V6.16307ZM2.5 7.62992V14.7835L7.19195 10.8457L2.5 7.62992Z", fill: "#FDD981" }), /* @__PURE__ */ reactExports.createElement("path", { fillRule: "evenodd", clipRule: "evenodd", d: "M17.9997 13.1937C16.734 13.1937 15.7079 14.2198 15.7079 15.4855C15.7079 16.7512 16.734 17.7772 17.9997 17.7772C19.2654 17.7772 20.2915 16.7512 20.2915 15.4855C20.2915 14.2198 19.2654 13.1937 17.9997 13.1937ZM16.958 15.4855C16.958 14.9102 17.4244 14.4438 17.9997 14.4438C18.575 14.4438 19.0414 14.9102 19.0414 15.4855C19.0414 16.0608 18.575 16.5272 17.9997 16.5272C17.4244 16.5272 16.958 16.0608 16.958 15.4855Z", fill: "#FDD981" }), /* @__PURE__ */ reactExports.createElement("path", { fillRule: "evenodd", clipRule: "evenodd", d: "M17.9996 9.57468C17.614 9.57468 17.2365 9.61167 16.8706 9.68248L16.5248 9.7494L16.0124 11.1391C15.7363 11.2656 15.4743 11.4176 15.2297 11.5921L13.7704 11.341L13.5395 11.6062C13.0461 12.173 12.6586 12.8352 12.4085 13.5622L12.294 13.8948L13.2434 15.0358C13.2295 15.1839 13.2225 15.3339 13.2225 15.4853C13.2225 15.6372 13.2296 15.7876 13.2435 15.9362L12.294 17.0773L12.4085 17.41C12.6586 18.1369 13.0461 18.7992 13.5395 19.3659L13.7704 19.6311L15.2314 19.3798C15.4753 19.5536 15.7365 19.7051 16.0118 19.8313L16.5248 21.2227L16.8706 21.2897C17.2365 21.3605 17.614 21.3974 17.9996 21.3974C18.385 21.3974 18.7623 21.3605 19.1281 21.2897L19.474 21.2228L19.9863 19.8331C20.2629 19.7067 20.5252 19.5547 20.7701 19.3802L22.2287 19.6312L22.4596 19.366C22.9529 18.7993 23.3404 18.1371 23.5905 17.4103L23.705 17.0776L22.7583 15.9398C22.7724 15.7901 22.7797 15.6385 22.7797 15.4853C22.7797 15.3326 22.7725 15.1815 22.7584 15.0322L23.705 13.8945L23.5905 13.5619C23.3404 12.835 22.9529 12.1728 22.4595 11.6061L22.2287 11.3409L20.7718 11.5916C20.5262 11.4165 20.2631 11.264 19.9857 11.1372L19.474 9.74931L19.1281 9.6824C18.7623 9.61165 18.385 9.57468 17.9996 9.57468ZM17.4488 10.8569C17.6292 10.8357 17.813 10.8247 17.9996 10.8247C18.186 10.8247 18.3697 10.8356 18.55 10.8568L19.0044 12.0894L19.2684 12.191C19.614 12.3241 19.9337 12.5102 20.2175 12.7396L20.4376 12.9175L21.733 12.6946C21.9525 12.9877 22.1382 13.3072 22.2844 13.6474L21.4438 14.6577L21.4873 14.9367C21.5151 15.1151 21.5296 15.2983 21.5296 15.4853C21.5296 15.6727 21.5151 15.8562 21.4872 16.035L21.4436 16.3141L22.2844 17.3247C22.1382 17.6649 21.9525 17.9845 21.733 18.2775L20.4363 18.0544L20.2163 18.2321C19.9329 18.4609 19.6138 18.6466 19.269 18.7794L19.005 18.8811L18.55 20.1153C18.3697 20.1365 18.186 20.1474 17.9996 20.1474C17.813 20.1474 17.6292 20.1365 17.4488 20.1153L16.9933 18.8799L16.7299 18.7781C16.3861 18.6453 16.068 18.46 15.7854 18.2317L15.5654 18.0539L14.266 18.2774C14.0465 17.9843 13.8608 17.6647 13.7146 17.3244L14.5579 16.3109L14.5146 16.0321C14.4869 15.8543 14.4725 15.6717 14.4725 15.4853C14.4725 15.2993 14.4869 15.1171 14.5144 14.9396L14.5576 14.6609L13.7146 13.6477C13.8608 13.3074 14.0465 12.9878 14.2661 12.6947L15.5641 12.918L15.7841 12.74C16.0671 12.5111 16.3859 12.3254 16.7304 12.1923L16.994 12.0905L17.4488 10.8569Z", fill: "#FDD981" }));
const MessageSetIcon = ({ className } = {}) => {
  return /* @__PURE__ */ jsxRuntimeExports.jsx(SvgIcon$2, { className: joinClass(css$7.defaultCss, className) });
};
const SvgIcon$1 = (props) => /* @__PURE__ */ reactExports.createElement("svg", { width: 26, height: 22, viewBox: "0 0 26 22", fill: "none", xmlns: "http://www.w3.org/2000/svg", ...props }, /* @__PURE__ */ reactExports.createElement("path", { fillRule: "evenodd", clipRule: "evenodd", d: "M0 6.99987V14.9999C0 15.5521 0.447715 15.9999 1 15.9999H6.5L12.3753 20.7001C13.0301 21.2239 14 20.7577 14 19.9192V2.08049C14 1.24199 13.0301 0.775811 12.3753 1.29962L6.5 5.99987H1C0.447715 5.99987 0 6.44758 0 6.99987ZM20.5409 3.39847C20.8337 3.10557 21.3086 3.10557 21.6015 3.39847C25.7996 7.5966 25.7996 14.4031 21.6015 18.6013C21.3086 18.8942 20.8337 18.8942 20.5409 18.6013C20.248 18.3084 20.248 17.8335 20.5409 17.5406C24.1532 13.9283 24.1532 8.07148 20.5409 4.45913C20.248 4.16623 20.248 3.69136 20.5409 3.39847ZM17.7124 6.22689C18.0053 5.934 18.4802 5.934 18.7731 6.22689C21.4091 8.86293 21.4091 13.1368 18.7731 15.7728C18.4802 16.0657 18.0053 16.0657 17.7124 15.7728C17.4195 15.4799 17.4195 15.0051 17.7124 14.7122C19.7627 12.6619 19.7627 9.33781 17.7124 7.28756C17.4195 6.99466 17.4195 6.51979 17.7124 6.22689Z", fill: "#FDD981" }));
const MessageVolumIcon = ({ className } = {}) => {
  return /* @__PURE__ */ jsxRuntimeExports.jsx(SvgIcon$1, { className: joinClass(css$7.defaultCss, className) });
};
const SvgIcon = (props) => /* @__PURE__ */ reactExports.createElement("svg", { width: 32, height: 32, viewBox: "0 0 32 32", fill: "none", xmlns: "http://www.w3.org/2000/svg", ...props }, /* @__PURE__ */ reactExports.createElement("g", { clipPath: "url(#clip0_14071_127637)" }, /* @__PURE__ */ reactExports.createElement("rect", { width: 32, height: 32, rx: 6.15385, fill: "#5378BF" }), /* @__PURE__ */ reactExports.createElement("rect", { x: 0.533333, y: 0.533333, width: 30.9333, height: 30.9333, rx: 5.62051, stroke: "white", strokeOpacity: 0.3, strokeWidth: 1.06667 }), /* @__PURE__ */ reactExports.createElement("path", { d: "M8 16L14.774 22.774L25.374 12.174", stroke: "white", strokeWidth: 3.2, strokeLinecap: "round", strokeLinejoin: "round" })), /* @__PURE__ */ reactExports.createElement("defs", null, /* @__PURE__ */ reactExports.createElement("clipPath", { id: "clip0_14071_127637" }, /* @__PURE__ */ reactExports.createElement("rect", { width: 32, height: 32, fill: "white" }))));
const SelectIcon = ({ className } = {}) => {
  return /* @__PURE__ */ jsxRuntimeExports.jsx(SvgIcon, { className: joinClass(css$7.defaultCss, className) });
};
const svg_theme_fill_color$6 = "_svg_theme_fill_color_qwxij_3";
const uploadContainer = "_uploadContainer_qwxij_55";
const fileInput = "_fileInput_qwxij_62";
const uploadButton = "_uploadButton_qwxij_66";
const item = "_item_qwxij_163";
const top = "_top_qwxij_167";
const botton = "_botton_qwxij_399";
const uploadButton2 = "_uploadButton2_qwxij_632";
const progressBar = "_progressBar_qwxij_752";
const statusMessage = "_statusMessage_qwxij_758";
const successMessage = "_successMessage_qwxij_763";
const errorMessage = "_errorMessage_qwxij_767";
const uploadImg = "_uploadImg_qwxij_771";
const tips$1 = "_tips_qwxij_784";
const css$6 = {
  svg_theme_fill_color: svg_theme_fill_color$6,
  uploadContainer,
  fileInput,
  uploadButton,
  item,
  top,
  botton,
  uploadButton2,
  progressBar,
  statusMessage,
  successMessage,
  errorMessage,
  uploadImg,
  tips: tips$1
};
const Upload = () => {
  reactExports.useState(null);
  reactExports.useState(0);
  const [uploadStatus, setUploadStatus] = reactExports.useState("");
  const [uploadResult, setUploadResult] = reactExports.useState(null);
  const handleFileChange = (event) => {
    setUploadStatus("ready");
    uploadFileFn(event.target.files[0]);
  };
  reactExports.useEffect(() => {
    events.on("closeUpload", handleEvent);
    return () => {
      events.off("closeUpload", handleEvent);
    };
  }, []);
  const handleEvent = () => {
    setUploadResult(null);
    setUploadStatus("");
  };
  async function uploadFileFn(file) {
    console.log("file :>> ", file);
    if (file.size / 1024 / 1024 > 50) {
      Message$1.error(
        trans("The file size cannot exceed {{size}}", { size: "50MB" })
      );
      return;
    }
    if (!file || uploadStatus == "loading")
      return;
    setUploadStatus("loading");
    try {
      const response = await S3PutObject(file);
      setUploadResult(response);
      events.emit("uploadSuccess", response);
      setUploadStatus("success");
    } catch (e) {
      console.error(e);
      setUploadStatus("error");
    }
  }
  const videoRef = reactExports.useRef(null);
  const handleVideoClick = () => {
    if (videoRef.current) {
      if (videoRef.current.paused) {
        videoRef.current.play();
      } else {
        videoRef.current.pause();
      }
    }
  };
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { children: [
    uploadResult && /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$6.uploadImg, children: uploadStatus == "loading" ? /* @__PURE__ */ jsxRuntimeExports.jsx(Spin, {}) : /* @__PURE__ */ jsxRuntimeExports.jsx(jsxRuntimeExports.Fragment, { children: uploadResult.type.includes("video") ? /* @__PURE__ */ jsxRuntimeExports.jsx(
      "video",
      {
        onClick: handleVideoClick,
        ref: videoRef,
        style: { width: "100rem", height: "100rem" },
        children: /* @__PURE__ */ jsxRuntimeExports.jsx(
          "source",
          {
            src: "".concat("").concat(uploadResult.fullPath),
            type: "video/mp4"
          }
        )
      }
    ) : /* @__PURE__ */ jsxRuntimeExports.jsx("img", { src: "".concat("").concat(uploadResult.fullPath) }) }) }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: joinClass(css$6.uploadContainer, "button"), children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx(
        "input",
        {
          type: "file",
          onChange: handleFileChange,
          accept: "image/*, video/*",
          id: "fileInput",
          className: css$6.fileInput
        }
      ),
      !uploadResult ? /* @__PURE__ */ jsxRuntimeExports.jsx("label", { htmlFor: "fileInput", className: css$6.uploadButton, children: uploadStatus == "loading" ? /* @__PURE__ */ jsxRuntimeExports.jsx(Spin, {}) : /* @__PURE__ */ jsxRuntimeExports.jsxs(jsxRuntimeExports.Fragment, { children: [
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$6.top, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$6.item }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$6.item })
        ] }),
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$6.botton, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$6.item }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$6.item })
        ] })
      ] }) }) : /* @__PURE__ */ jsxRuntimeExports.jsx("label", { htmlFor: "fileInput", style: { display: "flex" }, children: /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: css$6.uploadButton2, children: trans("Resend") }) })
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$6.tips, children: trans("The file size cannot exceed {{size}}", { size: "50MB" }) })
  ] });
};
const svg_theme_fill_color$5 = "_svg_theme_fill_color_1xv8y_3";
const messageBox$1 = "_messageBox_1xv8y_55";
const contentBox$4 = "_contentBox_1xv8y_79";
const inSetBox = "_inSetBox_1xv8y_84";
const showNotice = "_showNotice_1xv8y_91";
const showMessage = "_showMessage_1xv8y_94";
const showFeedback = "_showFeedback_1xv8y_97";
const css$5 = {
  svg_theme_fill_color: svg_theme_fill_color$5,
  messageBox: messageBox$1,
  contentBox: contentBox$4,
  inSetBox,
  showNotice,
  showMessage,
  showFeedback
};
const svg_theme_fill_color$4 = "_svg_theme_fill_color_14cge_3";
const headerBox = "_headerBox_14cge_55";
const leftBox$2 = "_leftBox_14cge_199";
const backArrowBox = "_backArrowBox_14cge_205";
const ico = "_ico_14cge_216";
const tabsBox = "_tabsBox_14cge_278";
const active$1 = "_active_14cge_363";
const numBox = "_numBox_14cge_480";
const rightBox$2 = "_rightBox_14cge_496";
const icon = "_icon_14cge_598";
const editBox = "_editBox_14cge_783";
const right_svg = "_right_svg_14cge_786";
const selectAll = "_selectAll_14cge_791";
const cancel = "_cancel_14cge_793";
const noCheck$1 = "_noCheck_14cge_806";
const css$4 = {
  svg_theme_fill_color: svg_theme_fill_color$4,
  headerBox,
  leftBox: leftBox$2,
  backArrowBox,
  ico,
  tabsBox,
  active: active$1,
  numBox,
  rightBox: rightBox$2,
  icon,
  editBox,
  right_svg,
  selectAll,
  "delete": "_delete_14cge_792",
  cancel,
  noCheck: noCheck$1
};
const Header = ({
  type,
  isEdit,
  selectList,
  messageList,
  onSelectAll,
  onDeleteMessage,
  onSelectType = () => {
  },
  updateIsEdit
}) => {
  const navigate = useNavigate();
  const { num: num2 } = useMessageStore();
  const { t } = useTranslation();
  return /* @__PURE__ */ jsxRuntimeExports.jsxs(jsxRuntimeExports.Fragment, { children: [
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$4.headerBox, children: /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$4.leftBox, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx(
        "div",
        {
          className: css$4.backArrowBox,
          onClick: () => {
            navigate(-1);
          },
          children: /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$4.ico, children: /* @__PURE__ */ jsxRuntimeExports.jsx(ArrowLeftInMineIcon, {}) })
        }
      ),
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$4.tabsBox, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          "div",
          {
            className: type === "service" ? css$4.active : "",
            onClick: () => {
              onSelectType("service");
            },
            children: t("Contact us")
          }
        ),
        /* @__PURE__ */ jsxRuntimeExports.jsxs(
          "div",
          {
            className: type === "message" ? css$4.active : "",
            onClick: () => {
              onSelectType("message");
            },
            children: [
              t("消息"),
              num2 ? /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$4.numBox, children: num2 }) : null
            ]
          }
        ),
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          "div",
          {
            className: type === "notice" ? css$4.active : "",
            onClick: () => {
              onSelectType("notice");
            },
            children: t("通知")
          }
        ),
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          "div",
          {
            className: type === "feedback" ? css$4.active : "",
            onClick: () => {
              onSelectType("feedback");
            },
            children: t("Suggestion Bonus")
          }
        )
      ] })
    ] }) }),
    type === "message" ? /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$4.rightBox, onClick: () => updateIsEdit(true), children: [
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$4.selectAll, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx(MessageSetIcon, { className: css$4.icon }),
        /* @__PURE__ */ jsxRuntimeExports.jsx("span", { children: t("管理") })
      ] }),
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$4.editBox, children: isEdit ? /* @__PURE__ */ jsxRuntimeExports.jsxs(jsxRuntimeExports.Fragment, { children: [
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$4.selectAll, onClick: (e) => {
          onSelectAll();
        }, children: [
          selectList.length === messageList.length ? /* @__PURE__ */ jsxRuntimeExports.jsx(SelectIcon, {}) : /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$4.noCheck }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("span", { children: t("全选") })
        ] }),
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$4.delete, onClick: () => onDeleteMessage(), children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx(DeleteIcon, { className: css$4.icon }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("span", { children: t("删除") })
        ] }),
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$4.cancel, onClick: (e) => {
          e.stopPropagation();
          updateIsEdit(false);
        }, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx(InputClearIcon, {}),
          /* @__PURE__ */ jsxRuntimeExports.jsx("span", { children: t("取消") })
        ] })
      ] }) : /* @__PURE__ */ jsxRuntimeExports.jsx(ArrowLeftInMineIcon, { className: css$4.right_svg }) })
    ] }) : null
  ] });
};
const svg_theme_fill_color$3 = "_svg_theme_fill_color_8dn44_3";
const messageBox = "_messageBox_8dn44_55";
const contentBox$3 = "_contentBox_8dn44_59";
const itemBox$1 = "_itemBox_8dn44_65";
const alreadySelect = "_alreadySelect_8dn44_184";
const leftBox$1 = "_leftBox_8dn44_266";
const iconBox$1 = "_iconBox_8dn44_271";
const readSpan = "_readSpan_8dn44_278";
const noMargin = "_noMargin_8dn44_292";
const noCheck = "_noCheck_8dn44_295";
const selectIcon = "_selectIcon_8dn44_415";
const infoBox$1 = "_infoBox_8dn44_587";
const title$3 = "_title_8dn44_592";
const time$1 = "_time_8dn44_667";
const readInfoBox = "_readInfoBox_8dn44_758";
const rightBox$1 = "_rightBox_8dn44_806";
const text$2 = "_text_8dn44_811";
const arrowIcon$2 = "_arrowIcon_8dn44_816";
const is_read = "_is_read_8dn44_887";
const css$3 = {
  svg_theme_fill_color: svg_theme_fill_color$3,
  messageBox,
  contentBox: contentBox$3,
  itemBox: itemBox$1,
  alreadySelect,
  leftBox: leftBox$1,
  iconBox: iconBox$1,
  readSpan,
  noMargin,
  noCheck,
  selectIcon,
  infoBox: infoBox$1,
  title: title$3,
  time: time$1,
  readInfoBox,
  rightBox: rightBox$1,
  text: text$2,
  arrowIcon: arrowIcon$2,
  is_read
};
const listMaps = {
  black: "/message/no_read_message_icon_black.webp",
  blue: "/message/no_read_message_icon_blue.webp",
  whiteGreen: "/message/no_read_message_icon_white_green.webp",
  purple: "/message/no_read_message_icon_purple.webp",
  oilyGreen: "/message/no_read_message_icon_oilyGreen.webp",
  whiteRed: "/message/no_read_message_icon_whiteRed.webp",
  versaceYellow: "/message/no_read_message_icon_versaceYellow.webp",
  lancomePeach: "/message/no_read_message_icon_lancomePeach.webp",
  hermesOrange: "/message/no_read_message_icon_hermes_orange.webp",
  whiteBlue: "/message/no_read_message_icon_whiteBlue.webp",
  whiteYellow: "/message/no_read_message_icon_whiteYellow.webp",
  lightBrown: "/message/no_read_message_icon_lightBrown.webp",
  whiteOrange: "/message/no_read_message_icon_whiteOrange.webp",
  furlaBlue: "/message/no_read_message_icon_furlaBlue.webp",
  whitePink: "/message/no_read_message_icon_whitePink.webp",
  bvGreen: "/message/no_read_message_icon_bvGreen.webp",
  whiteBrown: "/message/no_read_message_icon_whiteBrown.webp",
  AnnaSuiPurple: "/message/no_read_message_icon_AnnaSuiPurple.webp",
  whitePurple: "/message/no_read_message_icon_whitePurple.webp",
  whiteDarkGreen: "/message/no_read_message_icon_whiteDarkGreen.webp",
  burgundyRed: "/message/no_read_message_icon_burgundyRe.webp",
  sk2: "/message/no_read_message_icon_sk2.webp",
  greenGold: "/message/no_read_message_icon_greenGold.webp",
  whiteRedGucci: "/message/no_read_message_icon_whiteRedGucci.webp",
  whiteBrownLauren: "/message/no_read_message_icon_whiteBrownLauren.webp",
  embraerBlue: "/message/no_read_message_icon_embraerBlue.webp",
  bvlgariBrown: "/message/no_read_message_icon_bvlgariBrown.webp",
  elsaPink: "/message/no_read_message_icon_elsaPink.webp",
  whiteBlack: "/message/no_read_message_icon_whiteBlack.webp"
};
const listReadMaps = {
  black: "/message/read_message_icon_black.webp",
  blue: "/message/read_message_icon_blue.webp",
  whiteGreen: "/message/read_message_icon_whiteGreen.webp",
  purple: "/message/read_message_icon_purple.webp",
  oilyGreen: "/message/read_message_icon_oilyGreen.webp",
  whiteRed: "/message/read_message_icon_whiteRed.webp",
  versaceYellow: "/message/read_message_icon_versaceYellow.webp",
  lancomePeach: "/message/read_message_icon_lancomePeach.webp",
  hermesOrange: "/message/read_message_icon_hermes_orange.webp",
  whiteBlue: "/message/read_message_icon_whiteBlue.webp",
  whiteYellow: "/message/read_message_icon_whiteYellow.webp",
  lightBrown: "/message/read_message_icon_lightBrown.webp",
  whiteOrange: "/message/read_message_icon_whiteOrange.webp",
  furlaBlue: "/message/read_message_icon_furlaBlue.webp",
  whitePink: "/message/read_message_icon_whitePink.webp",
  bvGreen: "/message/read_message_icon_bvGreen.webp",
  whiteBrown: "/message/read_message_icon_whiteBrown.webp",
  AnnaSuiPurple: "/message/read_message_icon_AnnaSuiPurple.webp",
  whitePurple: "/message/read_message_icon_whitePurple.webp",
  whiteDarkGreen: "/message/read_message_icon_whiteDarkGreen.webp",
  burgundyRed: "/message/read_message_icon_burgundyRed.webp",
  sk2: "/message/read_message_icon_sk2.webp",
  greenGold: "/message/read_message_icon_greenGold.webp",
  whiteRedGucci: "/message/read_message_icon_whiteRedGucci.webp",
  whiteBrownLauren: "/message/read_message_icon_whiteBrownLauren.webp",
  embraerBlue: "/message/read_message_icon_embraerBlue.webp",
  bvlgariBrown: "/message/read_message_icon_bvlgariBrown.webp",
  elsaPink: "/message/read_message_icon_elsaPink.webp",
  whiteBlack: "/message/read_message_icon_whiteBlack.webp"
};
const MessageBox = ({
  messageList,
  isEdit,
  children,
  selectList = [],
  onSelect
}) => {
  const { getMessageNumBySotre } = useMessageStore((state) => state);
  const { theme } = useUserInfoStore();
  const navigate = useNavigate();
  return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$3.messageBox, children: /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$3.contentBox, children: [
    messageList.length === 0 ? /* @__PURE__ */ jsxRuntimeExports.jsx(Empty, {}) : messageList.map((message, idx) => {
      const isSelect = selectList.indexOf(message.id) > -1;
      return /* @__PURE__ */ jsxRuntimeExports.jsxs(
        "div",
        {
          className: joinClass(
            css$3.itemBox,
            isSelect && isEdit ? css$3.alreadySelect : "",
            message.is_read === 0 ? css$3.is_read : ""
          ),
          onClick: async () => {
            if (isEdit) {
              onSelect(message.id);
              return;
            }
            Cache.set("messageDetail", {
              ...message,
              page_type: "message"
            });
            navigate("/messageDetail");
            if (message.is_read === 0) {
              await readUserMessage({ id: message.id });
              getMessageNumBySotre();
            }
          },
          children: [
            /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$3.leftBox, children: [
              isEdit ? /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: joinClass(css$3.iconBox, css$3.noMargin), children: isSelect ? /* @__PURE__ */ jsxRuntimeExports.jsx(SelectIcon, { className: css$3.selectIcon }) : /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$3.noCheck }) }) : null,
              /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$3.iconBox, children: message.is_read === 0 ? /* @__PURE__ */ jsxRuntimeExports.jsx(
                Image,
                {
                  src: listMaps[theme] || "/message/no_read_message_icon.webp"
                }
              ) : /* @__PURE__ */ jsxRuntimeExports.jsx(
                Image,
                {
                  src: listReadMaps[theme] || listMaps[theme] || "/message/no_read_message_icon.webp"
                }
              ) }),
              /* @__PURE__ */ jsxRuntimeExports.jsxs(
                "div",
                {
                  className: "".concat(css$3.infoBox, " ").concat(message.is_read === 0 ? "" : css$3.readInfoBox),
                  children: [
                    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$3.title, children: message.title }),
                    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$3.time, children: customFormatTimer(message.send_at) })
                  ]
                }
              )
            ] }),
            /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$3.rightBox, children: /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$3.arrowIcon, children: /* @__PURE__ */ jsxRuntimeExports.jsx(ArrowLeftInMineIcon, {}) }) })
          ]
        },
        idx
      );
    }),
    children
  ] }) });
};
const svg_theme_fill_color$2 = "_svg_theme_fill_color_d2foy_3";
const noticeBox = "_noticeBox_d2foy_55";
const contentBox$2 = "_contentBox_d2foy_59";
const itemBox = "_itemBox_d2foy_64";
const leftBox = "_leftBox_d2foy_178";
const iconBox = "_iconBox_d2foy_183";
const infoBox = "_infoBox_d2foy_351";
const title$2 = "_title_d2foy_358";
const time = "_time_d2foy_440";
const rightBox = "_rightBox_d2foy_533";
const text$1 = "_text_d2foy_538";
const arrowIcon$1 = "_arrowIcon_d2foy_543";
const css$2 = {
  svg_theme_fill_color: svg_theme_fill_color$2,
  noticeBox,
  contentBox: contentBox$2,
  itemBox,
  leftBox,
  iconBox,
  infoBox,
  title: title$2,
  time,
  rightBox,
  text: text$1,
  arrowIcon: arrowIcon$1
};
const NoticeBox = ({ type }) => {
  const navigate = useNavigate();
  const state = useReactive({
    list: []
  });
  useAsyncEffect(async () => {
    if (type !== "notice")
      return;
    const [res] = await getNoticeList();
    if (res && Array.isArray(res) && res.length > 0) {
      state.list = res;
    }
  }, [type]);
  const { list: list2 } = state;
  return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.noticeBox, children: /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.contentBox, children: list2.length === 0 ? /* @__PURE__ */ jsxRuntimeExports.jsx(Empty, {}) : list2.map((message, idx) => {
    return /* @__PURE__ */ jsxRuntimeExports.jsxs(
      "div",
      {
        className: css$2.itemBox,
        onClick: async () => {
          Cache.set("messageDetail", {
            ...message,
            page_type: "notice"
          });
          navigate("/messageDetail");
        },
        children: [
          /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$2.leftBox, children: [
            /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.iconBox, children: /* @__PURE__ */ jsxRuntimeExports.jsx(MessageVolumIcon, {}) }),
            /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$2.infoBox, children: [
              /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.title, children: message.title }),
              /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.time, children: customFormatTimer(message.created_at) })
            ] })
          ] }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.rightBox, children: /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.arrowIcon, children: /* @__PURE__ */ jsxRuntimeExports.jsx(ArrowLeftInMineIcon, {}) }) })
        ]
      },
      idx
    );
  }) }) });
};
const svg_theme_fill_color$1 = "_svg_theme_fill_color_1qf7r_3";
const ServiceBox$1 = "_ServiceBox_1qf7r_55";
const contentBox$1 = "_contentBox_1qf7r_60";
const online = "_online_1qf7r_63";
const left$1 = "_left_1qf7r_155";
const right$1 = "_right_1qf7r_161";
const title$1 = "_title_1qf7r_164";
const desc = "_desc_1qf7r_217";
const btn$1 = "_btn_1qf7r_305";
const telegram = "_telegram_1qf7r_378";
const content = "_content_1qf7r_60";
const img = "_img_1qf7r_544";
const telegramContent = "_telegramContent_1qf7r_636";
const middle = "_middle_1qf7r_737";
const css$1 = {
  svg_theme_fill_color: svg_theme_fill_color$1,
  ServiceBox: ServiceBox$1,
  contentBox: contentBox$1,
  online,
  left: left$1,
  right: right$1,
  title: title$1,
  desc,
  btn: btn$1,
  telegram,
  content,
  img,
  telegramContent,
  middle
};
const ServiceBox = () => {
  const [customerList, setCustomerList] = reactExports.useState([]);
  const [onlineService, setOnlineService] = reactExports.useState({});
  const { t, i18n } = useTranslation();
  const getOnlineService = async () => {
    const [res, error] = await getMemberCustomerList({
      flag: "1"
    });
    if (error)
      return;
    if (res && res.length > 0) {
      setOnlineService(res[0]);
    }
  };
  const getCustomerList = async () => {
    const [res, error] = await getMemberCustomerList({
      flag: "3"
    });
    if (error)
      return;
    setCustomerList(res || []);
  };
  const onlineObj = reactExports.useMemo(() => {
    if (onlineService.items && onlineService.items.length > 0) {
      return {
        im: onlineService.items[0].im,
        link: onlineService.items[0].link,
        name: onlineService.items[0].name,
        remark: onlineService.items[0].remark,
        status: onlineService.items[0].status
      };
    }
    return {};
  }, [onlineService]);
  reactExports.useEffect(() => {
    getCustomerList();
    getOnlineService();
  }, []);
  return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$1.ServiceBox, children: /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.contentBox, children: [
    onlineObj.im && onlineObj.status == 2 && /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.online, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { className: css$1.left, src: onlineObj.im, remote: true, isGame: true }),
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.right, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$1.title, children: onlineObj.name }),
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$1.desc, children: onlineObj.remark }),
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          Button,
          {
            className: css$1.btn,
            onClick: () => {
              if (!onlineObj.link) {
                Message$1.error(t("暂无客服"));
                return;
              }
              window.open(onlineObj.link, "_blank");
            },
            children: t("现在联系")
          }
        )
      ] })
    ] }),
    customerList && customerList.map((item2, index) => {
      var _a, _b, _c;
      item2.items = (_a = item2.items) == null ? void 0 : _a.filter((i) => i.status == 2);
      return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { children: [
        ((_b = item2.items) == null ? void 0 : _b.length) ? /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$1.telegram, children: /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.content, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { className: css$1.img, src: item2.im, remote: true, isGame: true }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("span", { children: item2.title })
        ] }) }) : null,
        ((_c = item2.items) == null ? void 0 : _c.length) ? item2.items.map((text2, i) => {
          return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.telegramContent, children: [
            /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { className: css$1.left, src: text2.im, remote: true, isGame: true }),
            /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.middle, children: [
              /* @__PURE__ */ jsxRuntimeExports.jsx("p", { children: text2.name }),
              /* @__PURE__ */ jsxRuntimeExports.jsx("span", { children: text2.remark })
            ] }),
            /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$1.right, children: /* @__PURE__ */ jsxRuntimeExports.jsx(
              Button,
              {
                className: css$1.btn,
                onClick: () => {
                  window.open(text2.link, "_blank");
                },
                children: t("现在联系")
              }
            ) })
          ] }, i);
        }) : null
      ] }, index);
    })
  ] }) });
};
const svg_theme_fill_color = "_svg_theme_fill_color_1hz88_3";
const feedback = "_feedback_1hz88_55";
const header = "_header_1hz88_59";
const left = "_left_1hz88_65";
const btn = "_btn_1hz88_69";
const active = "_active_1hz88_198";
const right = "_right_1hz88_342";
const monye = "_monye_1hz88_346";
const pendente = "_pendente_1hz88_357";
const num = "_num_1hz88_444";
const btns = "_btns_1hz88_531";
const btns2 = "_btns2_1hz88_545";
const contentBox = "_contentBox_1hz88_641";
const add = "_add_1hz88_648";
const title = "_title_1hz88_740";
const contentTxt = "_contentTxt_1hz88_915";
const numTxt = "_numTxt_1hz88_1155";
const imgHead = "_imgHead_1hz88_1245";
const footHead = "_footHead_1hz88_1422";
const tips = "_tips_1hz88_1490";
const btnBottn = "_btnBottn_1hz88_1581";
const listBox = "_listBox_1hz88_1794";
const list = "_list_1hz88_1794";
const listHead = "_listHead_1hz88_1918";
const id = "_id_1hz88_1927";
const copyIcon = "_copyIcon_1hz88_1975";
const rightAdopted = "_rightAdopted_1hz88_2154";
const arrowIcon = "_arrowIcon_1hz88_2159";
const listContent = "_listContent_1hz88_2244";
const updateTime = "_updateTime_1hz88_2247";
const listText = "_listText_1hz88_2252";
const listTextReply = "_listTextReply_1hz88_2258";
const detailImg = "_detailImg_1hz88_2313";
const detailTime = "_detailTime_1hz88_2324";
const detailContent = "_detailContent_1hz88_2519";
const text = "_text_1hz88_2524";
const line = "_line_1hz88_2641";
const updatedAt = "_updatedAt_1hz88_2707";
const replyContent = "_replyContent_1hz88_2875";
const css = {
  svg_theme_fill_color,
  feedback,
  header,
  left,
  btn,
  active,
  right,
  monye,
  pendente,
  num,
  btns,
  btns2,
  contentBox,
  add,
  title,
  contentTxt,
  numTxt,
  imgHead,
  footHead,
  tips,
  btnBottn,
  listBox,
  list,
  listHead,
  id,
  copyIcon,
  rightAdopted,
  arrowIcon,
  listContent,
  updateTime,
  listText,
  listTextReply,
  detailImg,
  detailTime,
  detailContent,
  text,
  line,
  updatedAt,
  replyContent
};
const Feedback = ({ type }) => {
  useNavigate();
  const { t, i18n } = useTranslation();
  const { theme, info } = useUserInfoStore();
  const state = useReactive({
    list: [],
    btnTpye: 1,
    text: "",
    attachment_url: "",
    attachment_type: "",
    detailType: false,
    //详情类型
    itemDetail: {},
    //详情数据
    amount: 0,
    page: 1,
    totle: 0
  });
  const withdraw = async (id2) => {
    const [res] = await withdrawFeedback({ uid: info.uid });
    if (res == 1e3) {
      Message$1.success(t("领取成功"));
      state.amount = 0;
    }
  };
  const handleScroll = () => {
    if (state.list.length < state.totle) {
      state.page++;
    }
  };
  const feedbackList = async () => {
    if (!info)
      return;
    let params = {
      uid: info.uid,
      //		用户id(必选)
      page: state.page,
      page_size: 10
    };
    const [res] = await listFeedback(params);
    if (res) {
      state.list = [...state.list, ...res.d || []];
      if (state.page == 1) {
        state.amount = res.a || 0;
        state.totle = res.t || 0;
      }
    }
  };
  reactExports.useEffect(() => {
    if (state.btnTpye == 2) {
      feedbackList();
    }
  }, [state.page]);
  const { list: list2, btnTpye, text: text2, detailType, itemDetail } = state;
  const maxLength = 500;
  const handleChange = (event) => {
    state.text = event.target.value;
  };
  const btnSbumit = async () => {
    let params = {
      uid: info.uid,
      //		用户id(必选)
      username: info.username,
      //		用户名称(必选)
      content: state.text,
      //		string		反馈内容(必选)
      attachment_url: state.attachment_url,
      //	string		上传附件(可选)
      attachment_type: state.attachment_type
      //	string		附件类型(可选) 1:图片 2:视频
      // currency: "", //	string		货币类型(可选)
    };
    if (params.content.trim() == "") {
      return Message$1.error(t("Feedback cannot be empty"));
    }
    const [res] = await addFeedback(params);
    if (res == 1e3) {
      Message$1.success(t("Thank you for your valuable feedback"));
      state.text = "";
      state.attachment_url = "";
      state.attachment_type = "";
      events.emit("closeUpload");
    }
  };
  reactExports.useEffect(() => {
    events.on("uploadSuccess", handleEvent);
    return () => {
      events.off("uploadSuccess", handleEvent);
    };
  }, []);
  const handleEvent = (data) => {
    if (data.type.includes("video")) {
      state.attachment_type = "2";
    } else {
      state.attachment_type = "1";
    }
    state.attachment_url = data.fullPath;
  };
  const btnDetail = (item2) => {
    state.detailType = true;
    state.itemDetail = item2;
  };
  const videoRef = reactExports.useRef(null);
  const handleVideoClick = () => {
    if (videoRef.current) {
      if (videoRef.current.paused) {
        videoRef.current.play();
      } else {
        videoRef.current.pause();
      }
    }
  };
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.feedback, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.header, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.left, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          "div",
          {
            className: joinClass(css.btn, btnTpye == 1 ? css.active : ""),
            onClick: () => {
              state.btnTpye = 1;
            },
            children: t("Create Feedback")
          }
        ),
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          "div",
          {
            className: joinClass(css.btn, btnTpye == 2 ? css.active : ""),
            onClick: () => {
              state.page = 1;
              state.list = [];
              state.btnTpye = 2;
              state.detailType = false;
              feedbackList();
            },
            children: t("My Feedback")
          }
        )
      ] }),
      btnTpye == 2 ? /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.right, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.monye, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.pendente, children: t("Reward") }),
          /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.num, children: [
            state.amount,
            " "
          ] })
        ] }),
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          "div",
          {
            onClick: () => {
              if (state.amount != 0)
                withdraw();
            },
            className: joinClass(
              state.amount != 0 ? css.btns2 : "",
              css.btns
            ),
            children: t("Claimi All")
          }
        )
      ] }) : /* @__PURE__ */ jsxRuntimeExports.jsx("div", {})
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.contentBox, children: btnTpye == 1 ? /* @__PURE__ */ jsxRuntimeExports.jsxs(jsxRuntimeExports.Fragment, { children: [
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.add, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.title, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("span", { children: t("Feed Content") }),
          /* @__PURE__ */ jsxRuntimeExports.jsxs("span", { children: [
            " (",
            t("Suggestions for revision"),
            ")"
          ] })
        ] }),
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.contentTxt, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx(
            "textarea",
            {
              value: text2,
              onChange: handleChange,
              placeholder: t(
                "Your opinions are valuable to us. All valuable opinions will be accepted, and once accepted, will be rewarded with cash prizes according to their usefulness. We welcome your opinions!"
              ),
              maxLength
            }
          ),
          /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.numTxt, children: [
            /* @__PURE__ */ jsxRuntimeExports.jsx("span", { children: text2.length }),
            "/",
            maxLength
          ] })
        ] }),
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.imgHead, children: [
          t("Pictures don't lie"),
          /* @__PURE__ */ jsxRuntimeExports.jsxs("span", { children: [
            "(",
            t("Easier to be adopted"),
            ")"
          ] })
        ] }),
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: /* @__PURE__ */ jsxRuntimeExports.jsx(Upload, {}) }),
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.footHead, children: t("Reward Rules") }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.tips, children: t(
            "We've set up huge bonuses specifically to collect feedback so that we can optimize the system and features to give you a better experience! Once accepted, rewards will be given based on the usefulness (except those not accepted)"
          ) })
        ] })
      ] }),
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.btnBottn, children: /* @__PURE__ */ jsxRuntimeExports.jsx(
        "div",
        {
          className: joinClass(css.btns, "button"),
          onClick: () => {
            btnSbumit();
          },
          children: t("Submit Feedback")
        }
      ) })
    ] }) : list2.length === 0 ? /* @__PURE__ */ jsxRuntimeExports.jsx(Empty, {}) : /* @__PURE__ */ jsxRuntimeExports.jsx(jsxRuntimeExports.Fragment, { children: /* @__PURE__ */ jsxRuntimeExports.jsx(
      "div",
      {
        className: css.listBox,
        onScroll: (event) => {
          const { scrollHeight, scrollTop, clientHeight } = event.currentTarget;
          if (scrollHeight - scrollTop === clientHeight) {
            handleScroll();
            console.log("已经滚动到底部");
          }
        },
        children: !detailType ? list2.map((item2, index) => {
          return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.list, children: [
            /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.listHead, children: [
              /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.left, children: [
                t("Feedback ID"),
                ":",
                /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: css.id, children: item2.id }),
                /* @__PURE__ */ jsxRuntimeExports.jsx(
                  "div",
                  {
                    className: css.copyIcon,
                    onClick: () => {
                      clipboardExports.copy(item2.id);
                      Message$1.success(t("复制成功"));
                    },
                    children: /* @__PURE__ */ jsxRuntimeExports.jsx(RectCopyIcon, {})
                  }
                )
              ] }),
              /* @__PURE__ */ jsxRuntimeExports.jsxs(
                "div",
                {
                  className: item2.state == 3 ? css.rightAdopted : css.right,
                  onClick: () => {
                    btnDetail(item2);
                  },
                  children: [
                    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: t(
                      item2.state == 2 ? t("Not adopted") : item2.state == 1 || item2.state == 3 ? t("Adopted") : t("Pendente")
                    ) }),
                    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.arrowIcon, children: /* @__PURE__ */ jsxRuntimeExports.jsx(ArrowLeftInMineIcon, {}) })
                  ]
                }
              )
            ] }),
            /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.listContent, children: [
              /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.updateTime, children: [
                /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: t("Feed Content") }),
                /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: customFormatTimer(item2.submit_time) })
              ] }),
              /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.listText, children: item2.content })
            ] }),
            item2.state != 0 && /* @__PURE__ */ jsxRuntimeExports.jsxs(jsxRuntimeExports.Fragment, { children: [
              /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.line }),
              /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.listContent, children: [
                /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.updateTime, children: [
                  /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { children: [
                    t("Official answer"),
                    ":"
                  ] }),
                  /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: customFormatTimer(item2.updated_at) })
                ] }),
                /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.listTextReply, children: item2.reply_content })
              ] })
            ] })
          ] }, index);
        }) : /* @__PURE__ */ jsxRuntimeExports.jsxs(jsxRuntimeExports.Fragment, { children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.detailImg, children: itemDetail && itemDetail.attachment_url && /* @__PURE__ */ jsxRuntimeExports.jsx(jsxRuntimeExports.Fragment, { children: itemDetail.attachment_type == "2" ? /* @__PURE__ */ jsxRuntimeExports.jsx("video", { onClick: handleVideoClick, ref: videoRef, children: /* @__PURE__ */ jsxRuntimeExports.jsx(
            "source",
            {
              src: "".concat("").concat(itemDetail.attachment_url),
              type: "video/mp4"
            }
          ) }) : /* @__PURE__ */ jsxRuntimeExports.jsx(
            "img",
            {
              src: "".concat("").concat(itemDetail.attachment_url)
            }
          ) }) }),
          /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.detailTime, children: [
            /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: t("Feed Content") }),
            /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: customFormatTimer(itemDetail.submit_time) })
          ] }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.detailContent, children: /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.text, children: itemDetail.content }) }),
          itemDetail.state != 0 && /* @__PURE__ */ jsxRuntimeExports.jsxs(jsxRuntimeExports.Fragment, { children: [
            /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.line }),
            /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.updatedAt, children: [
              /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: t("Official answer") }),
              /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: customFormatTimer(itemDetail.updated_at) })
            ] }),
            /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.replyContent, children: /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.text, children: itemDetail.reply_content }) })
          ] })
        ] })
      }
    ) }) })
  ] });
};
const Message = () => {
  const { getMessageNumBySotre } = useMessageStore();
  const search = window.location.search;
  const params = new URLSearchParams(search);
  const to = params.get("service");
  const state = useReactive({
    type: "",
    // message, notice,
    page: 0,
    total: 0,
    page_size: 10,
    messageList: [],
    selectList: [],
    isEdit: false
  });
  const onSelectType = (t) => {
    state.type = t;
  };
  const getMessageListByAction = async (page2 = 1) => {
    if (page2 === 1)
      state.total = 0;
    const [res] = await getMessageList({ page: page2, page_size: state.page_size });
    if (res) {
      if (page2 === 1) {
        state.messageList = res.d || [];
      } else {
        state.messageList = [...state.messageList, ...res.d];
      }
      state.page = page2;
      if (page2 === 1)
        state.total = res.t;
    }
  };
  useAsyncEffect(async () => {
    if (state.type === "message")
      await getMessageListByAction(1);
  }, [state.type]);
  reactExports.useEffect(() => {
    if (to) {
      state.type = "service";
    } else {
      state.type = "message";
    }
    const onReceiveMessage = () => {
      getMessageListByAction(1);
    };
    events.on("ReceiveMessage", onReceiveMessage);
    return () => {
      events.off("ReceiveMessage", onReceiveMessage);
    };
  }, []);
  const updateIsEdit = (status) => {
    state.isEdit = status;
  };
  const onSelect = (id2) => {
    const selectList2 = state.selectList;
    const index = selectList2.indexOf(id2);
    if (index === -1) {
      selectList2.push(id2);
      state.selectList = [...selectList2];
      return;
    }
    selectList2.splice(index, 1);
    state.selectList = [...selectList2];
  };
  const onSelectAll = () => {
    const { messageList: messageList2, selectList: selectList2 } = state;
    if (messageList2.length === selectList2.length) {
      state.selectList = [];
    } else {
      state.selectList = [...messageList2.map((item2) => item2.id)];
    }
  };
  const deleteMessage = async () => {
    const { selectList: selectList2 } = state;
    if (selectList2.length === 0)
      return;
    await deleteUserMessage(
      { flag: 1, ids: selectList2.join(",") },
      { useLoading: true }
    );
    getMessageListByAction(1);
    getMessageNumBySotre();
  };
  const { type, messageList, isEdit, selectList, total, page } = state;
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$5.messageBox, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsx(
      Header,
      {
        type: state.type,
        onSelectType,
        selectList,
        messageList,
        onSelectAll,
        onDeleteMessage: deleteMessage,
        isEdit,
        updateIsEdit
      }
    ),
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$5.contentBox, children: /* @__PURE__ */ jsxRuntimeExports.jsxs(
      "div",
      {
        className: joinClass(
          css$5.inSetBox,
          type === "message" ? css$5.showMessage : type === "feedback" ? css$5.showFeedback : type === "service" ? "" : css$5.showNotice
        ),
        children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx(ServiceBox, {}),
          /* @__PURE__ */ jsxRuntimeExports.jsx(
            MessageBox,
            {
              type,
              messageList,
              isEdit,
              selectList,
              onSelect: (id2) => onSelect(id2),
              children: total > messageList.length ? /* @__PURE__ */ jsxRuntimeExports.jsx(
                LoadMore,
                {
                  className: css$5.loadMoreBtn,
                  onClick: () => {
                    getMessageListByAction(page + 1);
                  }
                }
              ) : null
            }
          ),
          /* @__PURE__ */ jsxRuntimeExports.jsx(NoticeBox, { type }),
          /* @__PURE__ */ jsxRuntimeExports.jsx(Feedback, { type })
        ]
      }
    ) })
  ] });
};
export {
  Message as default
};
