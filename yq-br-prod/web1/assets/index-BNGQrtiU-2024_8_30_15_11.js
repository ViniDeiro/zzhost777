import { q as useUserInfoStore, B as useGameStore, x as useNavigate, b8 as useGuideStore, r as reactExports, K as jsxRuntimeExports, R as Image, a9 as instance, P as joinClass, ad as getCountryFlag, aa as customToFixed, S as trans, aj as events, s as browser, bb as getBanner, a0 as minPxChip, b0 as getBrowser, C as useMessageStore, E as getMoneyUnit, bc as useInViewport, aY as sortGameTabs, aZ as scrollToPlatromItem, bd as getAwardAmount, a7 as Message, be as getHotGames, bf as getPlatLaunch, G as Cache, bg as historySave, bh as favoritesremove, bi as favorites, aA as useFloatPopShareStore, bj as favoritesList, bk as historyList } from "./index-a_Ow1xUN-2024_8_30_15_11.js";
import { a as useWebsetConfig, G as GameTabs$1, b as Guide, D as DanceNum, F as Fresh, M as Modal, c as DepositDialog, d as useReactive, e as useAsyncEffect, f as useGetState, g as gameTypeNames, I as InfoTabs, T as ToolTabs, h as useSetState, L as LoadingImg, i as LoadMore, j as clipboardExports } from "./App-D9NLPZJN-2024_8_30_15_11.js";
import { SearchToolIconS } from "./SearchToolS-BBajhuVB-2024_8_30_15_11.js";
import { TriangleIcon } from "./Triangle-Et9Bhd3y-2024_8_30_15_11.js";
import { SiderMenuIcon } from "./SiderMenuIcon-C-dPct6p-2024_8_30_15_11.js";
import { u as useActivityNavigate } from "./util-voEpZeRQ-2024_8_30_15_11.js";
import { M as Maintain } from "./index-Cw8D1bq7-2024_8_30_15_11.js";
import { ActionHotIcon } from "./ActionHotIcon-DaKu13yQ-2024_8_30_15_11.js";
import { T as TypeGame } from "./index-hOOyKCVU-2024_8_30_15_11.js";
import { S as SearchInput } from "./index-Bhw2MjsX-2024_8_30_15_11.js";
import "./s3-CXhGbR_j-2024_8_30_15_11.js";
const svg_theme_fill_color$d = "_svg_theme_fill_color_10ypj_3";
const headerBox = "_headerBox_10ypj_55";
const leftBox$3 = "_leftBox_10ypj_157";
const menuIcon = "_menuIcon_10ypj_163";
const left = "_left_10ypj_157";
const right = "_right_10ypj_171";
const logo$1 = "_logo_10ypj_244";
const rightBox$3 = "_rightBox_10ypj_249";
const moneyBox = "_moneyBox_10ypj_254";
const moneyBox2 = "_moneyBox2_10ypj_254";
const currency = "_currency_10ypj_273";
const loginBtn = "_loginBtn_10ypj_340";
const messageBox$1 = "_messageBox_10ypj_463";
const messageIcon$1 = "_messageIcon_10ypj_472";
const num$2 = "_num_10ypj_480";
const despositOutBtnBox = "_despositOutBtnBox_10ypj_495";
const line = "_line_10ypj_573";
const triangLeIconBox = "_triangLeIconBox_10ypj_647";
const show = "_show_10ypj_655";
const menuBox = "_menuBox_10ypj_725";
const dep = "_dep_10ypj_828";
const saq = "_saq_10ypj_829";
const despositBtn = "_despositBtn_10ypj_932";
const registerBtn = "_registerBtn_10ypj_1023";
const moneyIcon = "_moneyIcon_10ypj_1192";
const moneySpan = "_moneySpan_10ypj_1200";
const loading = "_loading_10ypj_1207";
const customDN = "_customDN_10ypj_1219";
const freshIcon = "_freshIcon_10ypj_1336";
const download$1 = "_download_10ypj_1417";
const closeIcon = "_closeIcon_10ypj_1518";
const downloadIcon = "_downloadIcon_10ypj_1523";
const btnIcon = "_btnIcon_10ypj_1526";
const download2 = "_download2_10ypj_1529";
const title = "_title_10ypj_1532";
const headerBox_search = "_headerBox_search_10ypj_1539";
const css$d = {
  svg_theme_fill_color: svg_theme_fill_color$d,
  headerBox,
  leftBox: leftBox$3,
  menuIcon,
  left,
  right,
  logo: logo$1,
  rightBox: rightBox$3,
  moneyBox,
  moneyBox2,
  currency,
  loginBtn,
  messageBox: messageBox$1,
  messageIcon: messageIcon$1,
  num: num$2,
  despositOutBtnBox,
  line,
  triangLeIconBox,
  show,
  menuBox,
  dep,
  saq,
  despositBtn,
  registerBtn,
  moneyIcon,
  moneySpan,
  loading,
  customDN,
  freshIcon,
  download: download$1,
  closeIcon,
  downloadIcon,
  btnIcon,
  download2,
  title,
  headerBox_search
};
const Header = () => {
  const {
    isShowSliderBox,
    updateSliderBoxStatus,
    theme,
    info,
    getUserBalanceByStore,
    appUrl,
    isSetWithdrawPassword,
    closeAppDownloadTopTips,
    token
  } = useUserInfoStore();
  const { gameSortMap } = useGameStore();
  const navigate = useNavigate();
  const { promptEvent, standalone } = useGuideStore();
  const [isShowMenu, setIsShowMenu] = reactExports.useState(false);
  const dom = reactExports.useRef(null);
  const { websetConfig } = useWebsetConfig();
  const downloadImg = {
    whiteGreen: "/home/icons/whiteGreen_download_close.webp"
  };
  const [depositStatus, setDepositStatus] = reactExports.useState(false);
  const guideRef = reactExports.useRef();
  const [loadingTime, setLoadingTime] = reactExports.useState(0);
  const reloadUserBalance = async () => {
    setLoadingTime(Date.now());
    await getUserBalanceByStore();
  };
  const downloadFn = () => {
    if (websetConfig.banner_switch === "2" && (browser.versions.ios || promptEvent)) {
      guideRef.current.saveToDesktop();
    } else {
      window.open(appUrl, "_blank");
    }
  };
  GameTabs$1.sort((a, b) => {
    return (a.sort || gameSortMap[a.type] || 0) - (b.sort || gameSortMap[b.type] || 0);
  });
  reactExports.useEffect(() => {
    setTimeout(() => {
      setLoadingTime(0);
    }, Math.max(500 - (Date.now() - loadingTime), 0));
  }, [info]);
  reactExports.useEffect(() => {
    if (isShowMenu) {
      const onMouseUp = (e) => {
        if (dom.current) {
          const parentElement = dom.current.parentElement;
          if (parentElement === e.target || parentElement.contains(e.target)) {
            return;
          }
          if (dom.current !== e.target && !dom.current.contains(e.target)) {
            setIsShowMenu(false);
          }
        }
      };
      document.addEventListener("touchend", onMouseUp);
      return () => {
        document.removeEventListener("touchend", onMouseUp);
      };
    }
  }, [isShowMenu]);
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { children: [
    !websetConfig.isHiddenDownloadApp && !standalone ? /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$d.download, id: "downloadDom", children: [
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          Image,
          {
            onClick: () => {
              closeAppDownloadTopTips();
            },
            src: downloadImg[theme] || "/home/icons/download_close.webp",
            className: css$d.closeIcon
          }
        ),
        websetConfig.banner_img ? /* @__PURE__ */ jsxRuntimeExports.jsx(
          Image,
          {
            src: websetConfig.banner_img,
            remote: true,
            isGame: true,
            className: css$d.downloadIcon
          }
        ) : /* @__PURE__ */ jsxRuntimeExports.jsx(
          Image,
          {
            src: "/xxxx/h5/download1.webp",
            className: css$d.downloadIcon
          }
        )
      ] }),
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$d.download2, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          Image,
          {
            onClick: () => {
              downloadFn();
            },
            src: "/home/icons/new_download2.webp",
            className: css$d.btnIcon
          }
        ),
        /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: css$d.title, children: instance.t("Baixar App") })
      ] })
    ] }) : null,
    /* @__PURE__ */ jsxRuntimeExports.jsxs(
      "div",
      {
        id: "headerBoxDom",
        className: joinClass(
          css$d.headerBox,
          !websetConfig.isHiddenDownloadApp ? css$d.topMargin : ""
        ),
        children: [
          /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$d.leftBox, children: [
            /* @__PURE__ */ jsxRuntimeExports.jsx(
              "div",
              {
                onClick: () => {
                  updateSliderBoxStatus(!isShowSliderBox);
                },
                className: joinClass(css$d.menuIcon, isShowSliderBox ? css$d.left : css$d.right),
                children: /* @__PURE__ */ jsxRuntimeExports.jsx(SiderMenuIcon, {})
              }
            ),
            websetConfig.logo_img ? /* @__PURE__ */ jsxRuntimeExports.jsx(
              Image,
              {
                src: websetConfig.logo_img,
                onClick: () => navigate("/"),
                className: css$d.logo,
                style: {
                  maxWidth: token ? "210rem" : "230rem"
                },
                remote: true,
                isGame: true
              }
            ) : null,
            /* @__PURE__ */ jsxRuntimeExports.jsx(Guide, { openPop: false, openGuide: false, event: guideRef })
          ] }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$d.rightBox, children: info ? /* @__PURE__ */ jsxRuntimeExports.jsxs(jsxRuntimeExports.Fragment, { children: [
            /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$d.moneyBox, children: [
              /* @__PURE__ */ jsxRuntimeExports.jsx(
                Image,
                {
                  className: css$d.moneyIcon,
                  src: getCountryFlag(true)
                }
              ),
              /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: css$d.moneySpan, children: /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$d.number, children: /* @__PURE__ */ jsxRuntimeExports.jsx(
                DanceNum,
                {
                  fontWeight: "400",
                  fontSize: "26",
                  color: "#EAB700",
                  ellipsis: 9,
                  num: customToFixed(info.balance || "0.00"),
                  className: css$d.customDN
                }
              ) }) }),
              /* @__PURE__ */ jsxRuntimeExports.jsx(Fresh, { className: css$d.freshIcon, onClick: reloadUserBalance })
            ] }),
            /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$d.despositOutBtnBox, children: [
              /* @__PURE__ */ jsxRuntimeExports.jsx(
                "div",
                {
                  className: css$d.despositBtn,
                  onClick: () => {
                    setDepositStatus(true);
                  },
                  children: instance.t("充值")
                }
              ),
              /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$d.line }),
              /* @__PURE__ */ jsxRuntimeExports.jsx(
                "div",
                {
                  className: joinClass(
                    css$d.triangLeIconBox,
                    isShowMenu ? css$d.show : ""
                  ),
                  onClick: () => {
                    setIsShowMenu(!isShowMenu);
                  },
                  children: /* @__PURE__ */ jsxRuntimeExports.jsx(TriangleIcon, {})
                }
              ),
              isShowMenu ? /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$d.menuBox, ref: dom, children: [
                /* @__PURE__ */ jsxRuntimeExports.jsx(
                  "div",
                  {
                    className: css$d.dep,
                    onClick: () => {
                      navigate("/deposit");
                    },
                    children: instance.t("充值")
                  }
                ),
                /* @__PURE__ */ jsxRuntimeExports.jsx(
                  "div",
                  {
                    className: css$d.saq,
                    onClick: () => {
                      if (isSetWithdrawPassword) {
                        navigate("/withdraw");
                      } else {
                        navigate("/withdraw-set?to=withdraw");
                      }
                    },
                    children: instance.t("提现")
                  }
                )
              ] }) : null
            ] })
          ] }) : /* @__PURE__ */ jsxRuntimeExports.jsxs(jsxRuntimeExports.Fragment, { children: [
            /* @__PURE__ */ jsxRuntimeExports.jsx(
              "div",
              {
                className: css$d.loginBtn,
                onClick: () => {
                  useUserInfoStore.setState({
                    openForLogin: true,
                    isShowSliderBox: false
                  });
                },
                children: trans("登录")
              }
            ),
            /* @__PURE__ */ jsxRuntimeExports.jsx(
              "div",
              {
                className: css$d.registerBtn,
                onClick: () => {
                  useUserInfoStore.setState({
                    openForRegister: true,
                    isShowSliderBox: false
                  });
                },
                children: trans("注册")
              }
            )
          ] }) }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$d.headerBox_search, onClick: () => {
            const firstSearchTabs = GameTabs$1.find((tab) => ["电子", "捕鱼", "棋牌", "小游戏"].includes(tab.type));
            events.emit("search", firstSearchTabs);
          }, children: /* @__PURE__ */ jsxRuntimeExports.jsx(SearchToolIconS, {}) })
        ]
      }
    ),
    /* @__PURE__ */ jsxRuntimeExports.jsx(Modal, { showType: "bottom", isOpen: depositStatus, onClose: (e) => e && e.stopPropagation(), children: /* @__PURE__ */ jsxRuntimeExports.jsx(DepositDialog, { setDepositStatus }) })
  ] });
};
const svg_theme_fill_color$c = "_svg_theme_fill_color_s64lj_3";
const carouselBox = "_carouselBox_s64lj_55";
const contentBox$1 = "_contentBox_s64lj_63";
const moveToRight = "_moveToRight_s64lj_70";
const moveToLeft = "_moveToLeft_s64lj_74";
const moveToCenter = "_moveToCenter_s64lj_78";
const points = "_points_s64lj_82";
const point_box = "_point_box_s64lj_90";
const point = "_point_s64lj_82";
const active = "_active_s64lj_104";
const css$c = {
  svg_theme_fill_color: svg_theme_fill_color$c,
  carouselBox,
  contentBox: contentBox$1,
  moveToRight,
  moveToLeft,
  moveToCenter,
  points,
  point_box,
  point,
  active
};
const svg_theme_fill_color$b = "_svg_theme_fill_color_11bva_3";
const bannerItemBox = "_bannerItemBox_11bva_55";
const lastImg = "_lastImg_11bva_63";
const middleImg = "_middleImg_11bva_71";
const nextImg = "_nextImg_11bva_78";
const css$b = {
  svg_theme_fill_color: svg_theme_fill_color$b,
  bannerItemBox,
  lastImg,
  middleImg,
  nextImg
};
const cacheState$1 = {
  startClientX: 0,
  endClientX: 0
};
const Item = (props = {}) => {
  const { item, imgs, index, updateSelectIndex } = props;
  const lastImg2 = imgs[index - 1] || null;
  const nextImg2 = imgs[index + 1] || null;
  const dom = reactExports.useRef({});
  const navigate = useNavigate();
  reactExports.useEffect(() => {
    if (dom.current) {
      const onTouchStart = (e) => {
        const touch = e.targetTouches[0] || {};
        cacheState$1.startClientX = touch.clientX || 0;
      };
      dom.current.addEventListener("touchstart", onTouchStart, {
        passive: true
      });
      const onTouchend = (e) => {
        const touch = e.changedTouches[0] || {};
        cacheState$1.endClientX = touch.clientX || 0;
        const cha = cacheState$1.endClientX - cacheState$1.startClientX;
        if (cha > 40) {
          if (lastImg2)
            updateSelectIndex(index - 1);
        }
        if (cha < -40) {
          if (nextImg2)
            updateSelectIndex(index + 1);
        }
      };
      dom.current.addEventListener("touchend", onTouchend, {
        passive: true
      });
      return () => {
        if (!dom.current)
          return;
        dom.current.removeEventListener("touchstart", onTouchStart, {
          passive: true
        });
        dom.current.removeEventListener("touchend", onTouchStart, {
          passive: true
        });
      };
    }
  }, [dom.current]);
  return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { ref: dom, className: css$b.bannerItemBox, children: /* @__PURE__ */ jsxRuntimeExports.jsx(
    Image,
    {
      remote: true,
      isGame: true,
      src: item.images,
      className: css$b.middleImg,
      onClick: () => {
        if (item.flags === "1") {
          navigate(item.url);
        }
        if (item.flags === "2") {
          window.open(item.url);
        }
      }
    }
  ) });
};
const cacheState = {
  timer: null,
  timeoutTimer: null
};
const Carousel = () => {
  const boxDom = reactExports.useRef();
  const state = useReactive({
    selectIdx: 0,
    imgs: [],
    // 无限滚动的最小的索引
    min: 0,
    // 无限滚动的最大的索引
    max: 0
  });
  const { imgs } = state;
  const checkoutPlayBack = () => {
    clearTimeout(cacheState.timeoutTimer);
    cacheState.timeoutTimer = setTimeout(() => {
      if (state.selectIdx > state.max) {
        if (boxDom.current)
          boxDom.current.style.transition = "all 0s ease-in-out";
        state.selectIdx = state.min;
        setTimeout(() => {
          if (boxDom.current)
            boxDom.current.style.transition = "all 0.2s ease-in-out";
        }, 0.2 * 1e3);
      }
      if (state.selectIdx < state.min) {
        if (boxDom.current)
          boxDom.current.style.transition = "all 0s ease-in-out";
        state.selectIdx = state.max;
        setTimeout(() => {
          if (boxDom.current)
            boxDom.current.style.transition = "all 0.2s ease-in-out";
        }, 0.2 * 1e3);
      }
    }, 0.3 * 1e3);
  };
  const updateSelectIndex = (index) => {
    if (index === state.selectIdx)
      return;
    if (imgs.length < 2)
      return;
    clearTimer();
    state.selectIdx = index;
    checkoutPlayBack();
    startTimer();
  };
  useAsyncEffect(async () => {
    if (imgs.length === 0) {
      clearTimer();
      const [res] = await getBanner({
        flags: 2
      });
      if (res && res.length > 0) {
        state.imgs = res;
        if (res.length > 0) {
          state.selectIdx = res.length;
          state.min = res.length;
          state.max = res.length * 2 - 1;
        }
        startTimer();
      }
    }
  }, [imgs]);
  reactExports.useEffect(() => {
    return () => {
      clearTimer();
    };
  }, []);
  const clearTimer = () => {
    clearInterval(cacheState.timer);
  };
  const startTimer = () => {
    cacheState.timer = setInterval(() => {
      state.selectIdx = state.selectIdx + 1;
      checkoutPlayBack();
    }, 3 * 1e3);
  };
  const { selectIdx } = state;
  const windowWidth = minPxChip() * 750;
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$c.carouselBox, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { ref: boxDom, style: { transform: "translateX(".concat(-1 * selectIdx * windowWidth, "px)") }, className: css$c.contentBox, children: [...imgs, ...imgs, ...imgs].map((item, idx) => {
      return /* @__PURE__ */ jsxRuntimeExports.jsx(
        Item,
        {
          updateSelectIndex: (idx2) => updateSelectIndex(idx2),
          index: idx,
          item,
          imgs: [...imgs, ...imgs, ...imgs]
        },
        idx
      );
    }) }),
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$c.points, children: /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$c.point_box, children: imgs.map((_, index) => {
      return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "".concat(css$c.point, " ").concat(state.selectIdx % (imgs.length || 0) == index && css$c.active) }, index);
    }) }) })
  ] });
};
const svg_theme_fill_color$a = "_svg_theme_fill_color_otwlg_3";
const noticeBox = "_noticeBox_otwlg_55";
const voiceIconBox = "_voiceIconBox_otwlg_70";
const textBox = "_textBox_otwlg_147";
const marquee = "_marquee_otwlg_155";
const space = "_space_otwlg_164";
const name = "_name_otwlg_173";
const gameName = "_gameName_otwlg_229";
const winText = "_winText_otwlg_288";
const money = "_money_otwlg_344";
const searchBox = "_searchBox_otwlg_404";
const messageBox = "_messageBox_otwlg_417";
const messageIcon = "_messageIcon_otwlg_423";
const num$1 = "_num_otwlg_452";
const span = "_span_otwlg_465";
const css$a = {
  svg_theme_fill_color: svg_theme_fill_color$a,
  noticeBox,
  voiceIconBox,
  textBox,
  marquee,
  space,
  name,
  gameName,
  winText,
  money,
  searchBox,
  messageBox,
  messageIcon,
  num: num$1,
  span
};
const Step0 = ({ className }) => {
  return /* @__PURE__ */ jsxRuntimeExports.jsx("svg", { xmlns: "http://www.w3.org/2000/svg", width: "34", height: "28", viewBox: "0 0 34 28", fill: "none", className, children: /* @__PURE__ */ jsxRuntimeExports.jsx(
    "path",
    {
      d: "M0 19.0909V8.90909C0 8.20618 0.56982 7.63636 1.27273 7.63636H8.27273L15.7504 1.65423C16.5837 0.987567 17.8182 1.58088 17.8182 2.64807V25.3519C17.8182 26.4191 16.5837 27.0124 15.7504 26.3458L8.27273 20.3636H1.27273C0.569819 20.3636 0 19.7938 0 19.0909Z",
      fill: "#2FA33F"
    }
  ) });
};
const Step1 = ({ className }) => {
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("svg", { xmlns: "http://www.w3.org/2000/svg", width: "34", height: "28", viewBox: "0 0 34 28", fill: "none", className, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsxs("g", { clipPath: "url(#clip0_506_7394)", children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx(
        "path",
        {
          fillRule: "evenodd",
          clipRule: "evenodd",
          d: "M22.543 7.92531C22.9157 7.55254 23.5201 7.55254 23.8929 7.92531C27.2478 11.2803 27.2478 16.7197 23.8929 20.0747C23.5201 20.4475 22.9157 20.4475 22.543 20.0747C22.1702 19.7019 22.1702 19.0975 22.543 18.7248C25.1524 16.1153 25.1524 11.8847 22.543 9.27524C22.1702 8.90247 22.1702 8.29808 22.543 7.92531Z",
          fill: "#2FA33F"
        }
      ),
      /* @__PURE__ */ jsxRuntimeExports.jsx(
        "path",
        {
          d: "M0 19.0909V8.90909C0 8.20618 0.56982 7.63636 1.27273 7.63636H8.27273L15.7504 1.65423C16.5837 0.987567 17.8182 1.58088 17.8182 2.64807V25.3519C17.8182 26.4191 16.5837 27.0124 15.7504 26.3458L8.27273 20.3636H1.27273C0.569819 20.3636 0 19.7938 0 19.0909Z",
          fill: "#2FA33F"
        }
      )
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsx("defs", { children: /* @__PURE__ */ jsxRuntimeExports.jsx("clipPath", { id: "clip0_506_7394", children: /* @__PURE__ */ jsxRuntimeExports.jsx("rect", { width: "33.0909", height: "28", fill: "white" }) }) })
  ] });
};
const Step2 = ({ className }) => {
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("svg", { xmlns: "http://www.w3.org/2000/svg", width: "34", height: "28", viewBox: "0 0 34 28", fill: "none", className, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsxs("g", { clipPath: "url(#clip0_506_7394)", children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx(
        "path",
        {
          fillRule: "evenodd",
          clipRule: "evenodd",
          d: "M26.1428 4.32549C26.5155 3.95272 27.1199 3.95272 27.4927 4.32549C32.8358 9.66858 32.8358 18.3314 27.4927 23.6745C27.1199 24.0473 26.5155 24.0473 26.1428 23.6745C25.77 23.3017 25.77 22.6973 26.1428 22.3246C30.7403 17.727 30.7403 10.273 26.1428 5.67542C25.77 5.30265 25.77 4.69827 26.1428 4.32549Z",
          fill: "#2FA33F"
        }
      ),
      /* @__PURE__ */ jsxRuntimeExports.jsx(
        "path",
        {
          fillRule: "evenodd",
          clipRule: "evenodd",
          d: "M22.543 7.92531C22.9157 7.55254 23.5201 7.55254 23.8929 7.92531C27.2478 11.2803 27.2478 16.7197 23.8929 20.0747C23.5201 20.4475 22.9157 20.4475 22.543 20.0747C22.1702 19.7019 22.1702 19.0975 22.543 18.7248C25.1524 16.1153 25.1524 11.8847 22.543 9.27524C22.1702 8.90247 22.1702 8.29808 22.543 7.92531Z",
          fill: "#2FA33F"
        }
      ),
      /* @__PURE__ */ jsxRuntimeExports.jsx(
        "path",
        {
          d: "M0 19.0909V8.90909C0 8.20618 0.56982 7.63636 1.27273 7.63636H8.27273L15.7504 1.65423C16.5837 0.987567 17.8182 1.58088 17.8182 2.64807V25.3519C17.8182 26.4191 16.5837 27.0124 15.7504 26.3458L8.27273 20.3636H1.27273C0.569819 20.3636 0 19.7938 0 19.0909Z",
          fill: "#2FA33F"
        }
      )
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsx("defs", { children: /* @__PURE__ */ jsxRuntimeExports.jsx("clipPath", { id: "clip0_506_7394", children: /* @__PURE__ */ jsxRuntimeExports.jsx("rect", { width: "33.0909", height: "28", fill: "white" }) }) })
  ] });
};
const VoiceIcon = ({ className }) => {
  const [setp, setStep, getSetp] = useGetState(0);
  reactExports.useEffect(() => {
    const timer = setInterval(() => {
      if (getSetp() === 2) {
        setStep(0);
      } else {
        setStep(getSetp() + 1);
      }
    }, 200);
    return () => {
      clearInterval(timer);
    };
  }, []);
  return /* @__PURE__ */ jsxRuntimeExports.jsx(jsxRuntimeExports.Fragment, { children: setp === 0 ? /* @__PURE__ */ jsxRuntimeExports.jsx(Step0, { className }) : setp === 1 ? /* @__PURE__ */ jsxRuntimeExports.jsx(Step1, { className }) : /* @__PURE__ */ jsxRuntimeExports.jsx(Step2, { className }) });
};
const isMobileIos = getBrowser().isIos && getBrowser().isMobile;
const Notice = () => {
  const navigate = useNavigate();
  const { num: num2 } = useMessageStore();
  const { marqueelist, getMarqueeByStore, theme, websetConfig } = useUserInfoStore();
  const messageImg = {
    black: "/home/icons/message_black.webp",
    whiteGreen: "/home/icons/message_whiteGreen.webp",
    purple: "/home/icons/message_purple.webp",
    oilyGreen: "/home/icons/message_oilyGreen.webp",
    blue: "/home/icons/message_blue.webp",
    whiteRed: "/home/icons/message_whiteRed.webp",
    versaceYellow: "/home/icons/message_versaceYellow.webp",
    lancomePeach: "/home/icons/message_lancomePeach.webp",
    hermesOrange: "/home/icons/message_hermesOrange.webp",
    whiteBlue: "/home/icons/message_whiteBlue.webp",
    sk2: "/home/icons/message_sk2.webp",
    whiteYellow: "/home/icons/message_whiteYellow.webp",
    lightBrown: "/home/icons/message_lightBrown.webp",
    whiteOrange: "/home/icons/message_whiteOrange.webp",
    furlaBlue: "/home/icons/message_furlaBlue.webp",
    whitePink: "/home/icons/message_whitePink.webp",
    bvGreen: "/home/icons/message_bvGreen.webp",
    whiteBrown: "/home/icons/message_whiteBrown.webp",
    AnnaSuiPurple: "/home/icons/message_AnnaSuiPurple.webp",
    whitePurple: "/home/icons/message_whitePurple.webp",
    burgundyRed: "/home/icons/message_burgundyRed.webp",
    whiteDarkGreen: "/home/icons/message_whiteDarkGreen.webp",
    greenGold: "/home/icons/message_greenGold.webp"
  };
  reactExports.useEffect(() => {
    getMarqueeByStore();
  }, []);
  const text = marqueelist.map((maq, i) => {
    const arr = maq.split("|");
    const str2 = '<span class="'.concat(css$a.space, '">\n      <span class="').concat(css$a.name, '">').concat(arr[2], '</span>\n      <span class="').concat(css$a.gameName, '">').concat(arr[1], '</span>\n      <span class="').concat(css$a.winText, '">ganhou</span>\n      <span class="').concat(css$a.money, '">').concat(getMoneyUnit(true), " ").concat(customToFixed(arr[3]), "</span>&nbsp;\n    </span>");
    return str2;
  });
  let numStr = num2 ? num2 : "";
  if (numStr > 99)
    numStr = "99+";
  const marqueeTxt = websetConfig.marqueeTxt || "";
  const txt2 = marqueeTxt.split("***").map((t, i) => {
    return '<span class="'.concat(css$a.winText, " ").concat(css$a.space, '">\n      ').concat(t.replace(/\s/g, " "), "\n    </span>");
  });
  const marqueeType = websetConfig.marqueeType || "";
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$a.noticeBox, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$a.voiceIconBox, children: /* @__PURE__ */ jsxRuntimeExports.jsx(VoiceIcon, { className: css$a.voiceIcon }) }),
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$a.textBox, children: /* @__PURE__ */ jsxRuntimeExports.jsx("marquee", { scrolldelay: isMobileIos ? "1" : "20", truespeed: "true", scrollamount: "1", dangerouslySetInnerHTML: {
      __html: marqueeType === "2" ? txt2 : text
    } }) }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs(
      "div",
      {
        className: css$a.messageBox,
        onClick: () => {
          navigate("/message");
        },
        children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$a.messageIcon, children: /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { src: messageImg[theme] || "/home/icons/message_black.webp" }) }),
          numStr ? /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$a.num, children: /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: css$a.span, children: numStr || "99+" }) }) : null
        ]
      }
    )
  ] });
};
const svg_theme_fill_color$9 = "_svg_theme_fill_color_tht9m_3";
const gameTabsBox = "_gameTabsBox_tht9m_55";
const leftArrowBox = "_leftArrowBox_tht9m_167";
const rightArrowBox = "_rightArrowBox_tht9m_168";
const hiden = "_hiden_tht9m_179";
const gameTabs = "_gameTabs_tht9m_55";
const container = "_container_tht9m_339";
const leftLine = "_leftLine_tht9m_345";
const tabItemBox = "_tabItemBox_tht9m_350";
const select = "_select_tht9m_495";
const icon$3 = "_icon_tht9m_652";
const iconSelect = "_iconSelect_tht9m_656";
const icons = "_icons_tht9m_668";
const small = "_small_tht9m_813";
const css$9 = {
  svg_theme_fill_color: svg_theme_fill_color$9,
  gameTabsBox,
  leftArrowBox,
  rightArrowBox,
  hiden,
  gameTabs,
  container,
  leftLine,
  tabItemBox,
  select,
  icon: icon$3,
  iconSelect,
  icons,
  small
};
const GameTabs = () => {
  const { games, selectType, gameOpenMap, gameSortMap } = useGameStore();
  const { appUrl, theme } = useUserInfoStore();
  const leftLineRef = reactExports.useRef();
  const rightLineRef = reactExports.useRef();
  const [leftLineRefInView] = useInViewport(leftLineRef);
  const [rightLineRefInView] = useInViewport(rightLineRef);
  const scrollDom = reactExports.useRef();
  const navigate = useNavigate();
  const tabsIcon = {
    black: "/home/icons/arr_icon_1.webp",
    blue: "/home/icons/arr_icon_2.webp",
    whiteGreen: "/home/icons/whiteGreen-arr_icon_2.webp",
    purple: "/home/icons/purple-arr_icon_2.webp",
    whiteRed: "/home/icons/whiteRed-arr_icon_2.webp",
    versaceYellow: "/home/icons/versaceYellow-arr_icon_2.webp",
    lancomePeach: "/home/icons/lancomePeach-arr_icon_2.webp",
    hermesOrange: "/home/icons/hermesOrange-arr_icon_2.webp",
    whiteBlue: "/home/icons/whiteBlue-arr_icon_2.webp",
    whiteYellow: "/home/icons/whiteYellow-arr_icon_2.webp",
    lightBrown: "/home/icons/lightBrown-arr_icon_2.webp",
    whiteOrange: "/home/icons/whiteOrange-arr_icon_2.webp",
    furlaBlue: "/home/icons/furlaBlue-arr_icon_2.webp",
    whitePink: "/home/icons/whitePink-arr_icon_2.webp",
    bvGreen: "/home/icons/bvGreen-arr_icon_2.webp",
    whiteBrown: "/home/icons/whiteBrown-arr_icon_2.webp",
    AnnaSuiPurple: "/home/icons/AnnaSuiPurple-arr_icon_2.webp",
    whitePurple: "/home/icons/whitePurple-arr_icon_2.webp",
    burgundyRed: "/home/icons/burgundyRed-arr_icon_2.webp",
    greenGold: "/home/icons/greenGold-arr_icon_2.webp",
    whiteDarkGreen: "/home/icons/whiteDarkGreen-arr_icon_2.webp"
  };
  GameTabs$1.sort((a, b) => {
    return (a.sort || gameSortMap[a.type] || 0) - (b.sort || gameSortMap[b.type] || 0);
  });
  reactExports.useEffect(() => {
    const dom = document.querySelector(".".concat(css$9.gameTabs));
    const select2 = dom.querySelector(".".concat(css$9.select));
    if (select2) {
      dom.scrollTo({
        left: select2.offsetLeft - dom.clientWidth / 2 + select2.clientWidth / 2,
        behavior: "smooth"
      });
    }
  }, [selectType]);
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$9.gameTabsBox, id: "gameTabsBox", children: [
    /* @__PURE__ */ jsxRuntimeExports.jsx(
      "div",
      {
        className: joinClass(
          css$9.leftArrowBox,
          leftLineRefInView ? css$9.hiden : ""
        ),
        onClick: () => {
          scrollDom.current.scrollTo({
            left: scrollDom.current.scrollLeft - scrollDom.current.clientWidth,
            behavior: "smooth"
          });
        },
        children: /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { src: tabsIcon[theme] || "/home/icons/arr_icon_2.webp" })
      }
    ),
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { ref: scrollDom, className: css$9.gameTabs, children: /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$9.container, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { ref: leftLineRef, className: css$9.leftLine }),
      sortGameTabs(GameTabs$1, games).map((tab, idx) => {
        if (!gameOpenMap[tab.type] && gameTypeNames.indexOf(tab.type) > -1)
          return null;
        if (!tab.grey)
          return null;
        if (!games.find((item) => item.name === tab.type) && tab.adminConfigShow === true)
          return null;
        const isSelect = selectType === tab.type;
        const IconsCom = tab.IconsCom || "";
        const ActiveIcons = tab.ActiveIcon || "";
        return /* @__PURE__ */ jsxRuntimeExports.jsxs(
          "div",
          {
            className: joinClass(
              css$9.tabItemBox,
              isSelect ? css$9.select : ""
            ),
            id: "label_".concat(tab.text),
            onClick: () => {
              if (tab.action === "router") {
                const gameItem = games.find(
                  (item) => item.name === tab.type
                );
                if (!gameItem)
                  return;
              }
              if (tab.action === "home") {
                navigate("/");
                useGameStore.setState({ selectType: tab.type });
                scrollToPlatromItem(GameTabs$1, tab.type);
                window.clickTabing = true;
                setTimeout(() => {
                  window.clickTabing = false;
                }, 100);
              }
            },
            children: [
              isSelect && !!ActiveIcons ? /* @__PURE__ */ jsxRuntimeExports.jsx(ActiveIcons, { className: joinClass(css$9.icon) }) : !!IconsCom ? /* @__PURE__ */ jsxRuntimeExports.jsx(
                IconsCom,
                {
                  className: joinClass(css$9.icons),
                  isSelect
                }
              ) : "",
              /* @__PURE__ */ jsxRuntimeExports.jsx("span", { text: tab.type, children: instance.t(tab.text) })
            ]
          },
          idx
        );
      }),
      InfoTabs.map((tab, idx) => {
        if (!tab.isShowInHome)
          return;
        const IconsCom = tab.IconsCom || "";
        return /* @__PURE__ */ jsxRuntimeExports.jsxs(
          "div",
          {
            className: css$9.tabItemBox,
            onClick: () => {
              navigate(tab.url);
            },
            children: [
              !!IconsCom ? /* @__PURE__ */ jsxRuntimeExports.jsx(IconsCom, { className: joinClass(css$9.icon, css$9.icons) }) : /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { className: css$9.icon, src: "/home/icons/".concat(tab.icon) }),
              /* @__PURE__ */ jsxRuntimeExports.jsx("span", { text: tab.type, children: instance.t(tab.text) })
            ]
          },
          idx
        );
      }),
      ToolTabs.map((tab, idx) => {
        if (!tab.isShowInHome)
          return;
        const IconsCom = tab.IconsCom || "";
        return /* @__PURE__ */ jsxRuntimeExports.jsxs(
          "div",
          {
            className: css$9.tabItemBox,
            onClick: () => {
              if (tab.path === "download") {
                window.open(appUrl, "_blank");
              }
            },
            children: [
              !!IconsCom ? /* @__PURE__ */ jsxRuntimeExports.jsx(IconsCom, { className: joinClass(css$9.icon, css$9.icons) }) : /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { className: css$9.icon, src: "/home/icons/".concat(tab.icon) }),
              /* @__PURE__ */ jsxRuntimeExports.jsx("span", { text: tab.type, children: instance.t(tab.text) })
            ]
          },
          idx
        );
      }),
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { ref: rightLineRef, className: css$9.leftLine })
    ] }) }),
    /* @__PURE__ */ jsxRuntimeExports.jsx(
      "div",
      {
        className: joinClass(
          css$9.rightArrowBox,
          rightLineRefInView ? css$9.hiden : ""
        ),
        onClick: () => {
          scrollDom.current.scrollTo({
            left: scrollDom.current.scrollLeft + scrollDom.current.clientWidth,
            behavior: "smooth"
          });
        },
        children: /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { src: tabsIcon[theme] || "/home/icons/arr_icon_2.webp" })
      }
    )
  ] });
};
const svg_theme_fill_color$8 = "_svg_theme_fill_color_1yxjv_3";
const str = "_str_1yxjv_55";
const num = "_num_1yxjv_65";
const css$8 = {
  svg_theme_fill_color: svg_theme_fill_color$8,
  str,
  num
};
const Nums = ({ n, idx, type, isLoading = false }) => {
  const isStr = n === "." || n === ",";
  const strMap = {
    ".": "_s",
    ",": "ss"
  };
  const nus = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 0];
  n = n === "t" ? 10 : n;
  n = isStr ? n : Number(n);
  const [styles, setStyles] = reactExports.useState({
    transitionDelay: "".concat((10 - idx) * 0.01, "s")
  });
  reactExports.useEffect(() => {
    const numEl = document.getElementById("jackpot_number_".concat(idx, "_").concat(n));
    if (numEl && !isLoading) {
      setStyles({
        ...styles,
        transform: "translateY(-".concat(numEl.offsetTop, "px)")
      });
    }
  }, [n, isLoading]);
  return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { style: isStr ? {} : styles, className: isStr ? css$8.str : css$8.num, children: isStr ? /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { src: "/home/jackpot/".concat(strMap[n], "_").concat(type, "_icon.webp") }) : /* @__PURE__ */ jsxRuntimeExports.jsx(jsxRuntimeExports.Fragment, { children: nus.map((nn, key) => {
    return /* @__PURE__ */ jsxRuntimeExports.jsx("span", { id: "jackpot_number_".concat(idx, "_").concat(nn), children: /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { src: "/home/jackpot/".concat(nn, "_").concat(type, "_icon.webp") }) }, key);
  }) }) });
};
const svg_theme_fill_color$7 = "_svg_theme_fill_color_1gbfi_3";
const pot_container = "_pot_container_1gbfi_55";
const bg = "_bg_1gbfi_64";
const bg_1 = "_bg_1_1gbfi_75";
const bg_2 = "_bg_2_1gbfi_79";
const bg_3 = "_bg_3_1gbfi_83";
const bg_4 = "_bg_4_1gbfi_87";
const numsBox = "_numsBox_1gbfi_91";
const numsBox_1 = "_numsBox_1_1gbfi_100";
const numsBox_2 = "_numsBox_2_1gbfi_104";
const numsBox_3 = "_numsBox_3_1gbfi_108";
const numsBox_4 = "_numsBox_4_1gbfi_112";
const css$7 = {
  svg_theme_fill_color: svg_theme_fill_color$7,
  pot_container,
  bg,
  bg_1,
  bg_2,
  bg_3,
  bg_4,
  numsBox,
  numsBox_1,
  numsBox_2,
  numsBox_3,
  numsBox_4
};
const BGComp = ({ type = 1, children, url, onClick }) => {
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$7.pot_container, onClick, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "".concat(css$7.bg, " ").concat(css$7.bg_1, " ").concat(css$7["bg_" + type]), children: /* @__PURE__ */ jsxRuntimeExports.jsx(
      Image,
      {
        isGame: type == 5,
        remote: type == 5,
        src: type == 5 ? url : "/home/jackpot/jackpot_bg_".concat(type, ".webp")
      }
    ) }),
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "".concat(css$7.numsBox, " ").concat(css$7.numsBox_1, " ").concat(css$7["numsBox_" + type]), children })
  ] });
};
const format = ["ttt.ttt.ttt", "ttt.ttt.ttt,t", "ttt.ttt.ttt,tt"];
const formatAmount = (num2, decimalLen) => {
  return format[decimalLen].split("").reverse().map((n, i) => {
    return num2.split("").reverse()[i] || (n === "t" ? 0 : n);
  }).reverse();
};
const Jackpot = ({ isShow }) => {
  const { switchPage } = useActivityNavigate();
  const { games, gameOpenMap, activityList } = useGameStore();
  const { award, websetConfig } = useUserInfoStore();
  const [amount, setAmount] = reactExports.useState(0);
  const [amountSplit, setAmountSplit] = reactExports.useState("ttt.ttt.ttt,tt".split(""));
  reactExports.useEffect(() => {
    getAwardAmount().then(([res]) => {
      if (res) {
        setAmount(res.amount);
        useUserInfoStore.setState({ prefix: res.prefix });
      }
    });
  }, []);
  reactExports.useEffect(() => {
    if (award) {
      setAmount(award);
    }
  }, [award]);
  reactExports.useEffect(() => {
    var _a;
    const decimalPlaces = String((_a = websetConfig.decimalPlaces) != null ? _a : 2);
    const num2 = customToFixed((amount || 0) / 100, decimalPlaces);
    setAmountSplit(formatAmount(num2, decimalPlaces));
  }, [amount, websetConfig.decimalPlaces]);
  const runToPage = () => {
    if (websetConfig.pool_forward_jump_type == "1") {
      const activity = activityList.find(
        (a) => a.id === websetConfig.pool_forward_id
      );
      if (activity) {
        switchPage({
          flag: websetConfig.pool_forward_flag,
          id: websetConfig.pool_forward_id
        });
      }
    } else if (websetConfig.pool_forward_jump_type == "2") {
      const g = games.find(
        (item) => item.id == websetConfig.pool_forward_game_type
      );
      if (g && gameOpenMap[g.name]) {
        const gl = g.l.find((l) => l.id === websetConfig.pool_forward_id);
        if (gl) {
          useGameStore.setState({
            selectType: g.name,
            selectGame: {
              pid: websetConfig.pool_forward_id,
              flag: 0,
              keyword: ""
            }
          });
        }
      }
    }
  };
  if (!isShow)
    return null;
  return /* @__PURE__ */ jsxRuntimeExports.jsx(
    BGComp,
    {
      type: websetConfig.pool_style || 1,
      url: websetConfig.pool_custom_style,
      onClick: runToPage,
      children: amountSplit.map((n, idx) => {
        return /* @__PURE__ */ jsxRuntimeExports.jsx(
          Nums,
          {
            n,
            idx,
            type: websetConfig.pool_money_style || 1
          },
          idx
        );
      })
    }
  );
};
const svg_theme_fill_color$6 = "_svg_theme_fill_color_fasfu_3";
const gamesBox = "_gamesBox_fasfu_55";
const css$6 = {
  svg_theme_fill_color: svg_theme_fill_color$6,
  gamesBox
};
const svg_theme_fill_color$5 = "_svg_theme_fill_color_oz5xe_3";
const gameBox$3 = "_gameBox_oz5xe_55";
const logoBox$3 = "_logoBox_oz5xe_62";
const laodingBox$3 = "_laodingBox_oz5xe_72";
const game_list_item_hots$3 = "_game_list_item_hots_oz5xe_153";
const game_list_item_hots_active$1 = "_game_list_item_hots_active_oz5xe_173";
const identifier$1 = "_identifier_oz5xe_1";
const gameBox_s$2 = "_gameBox_s_oz5xe_201";
const platformText$2 = "_platformText_oz5xe_216";
const game_recommend$1 = "_game_recommend_oz5xe_231";
const css$5 = {
  svg_theme_fill_color: svg_theme_fill_color$5,
  gameBox: gameBox$3,
  logoBox: logoBox$3,
  laodingBox: laodingBox$3,
  game_list_item_hots: game_list_item_hots$3,
  game_list_item_hots_active: game_list_item_hots_active$1,
  identifier: identifier$1,
  gameBox_s: gameBox_s$2,
  platformText: platformText$2,
  game_recommend: game_recommend$1
};
const svg_theme_fill_color$4 = "_svg_theme_fill_color_tj70h_3";
const itemBox = "_itemBox_tj70h_55";
const topBarBox = "_topBarBox_tj70h_63";
const leftBox$2 = "_leftBox_tj70h_71";
const icon$2 = "_icon_tj70h_77";
const platformLogo$2 = "_platformLogo_tj70h_89";
const rightBox$2 = "_rightBox_tj70h_130";
const itemsContainer = "_itemsContainer_tj70h_198";
const gameBox$2 = "_gameBox_tj70h_205";
const logoBox$2 = "_logoBox_tj70h_212";
const laodingBox$2 = "_laodingBox_tj70h_223";
const whiteLogo = "_whiteLogo_tj70h_304";
const nameBox = "_nameBox_tj70h_324";
const game_list_item_hots$2 = "_game_list_item_hots_tj70h_366";
const game_list_item_hots_active = "_game_list_item_hots_active_tj70h_386";
const identifier = "_identifier_tj70h_1";
const game_recommend = "_game_recommend_tj70h_393";
const btmLoadMoreBox = "_btmLoadMoreBox_tj70h_421";
const tips = "_tips_tj70h_427";
const loadMoreBtn = "_loadMoreBtn_tj70h_495";
const css$4 = {
  svg_theme_fill_color: svg_theme_fill_color$4,
  itemBox,
  topBarBox,
  leftBox: leftBox$2,
  icon: icon$2,
  platformLogo: platformLogo$2,
  rightBox: rightBox$2,
  itemsContainer,
  gameBox: gameBox$2,
  logoBox: logoBox$2,
  laodingBox: laodingBox$2,
  whiteLogo,
  nameBox,
  game_list_item_hots: game_list_item_hots$2,
  game_list_item_hots_active,
  identifier,
  game_recommend,
  btmLoadMoreBox,
  tips,
  loadMoreBtn
};
const platTypeIds = [3, 2, 5, 9];
const HotGameItem = ({ item, remote }) => {
  const navigate = useNavigate();
  const { games, gameNamesMap, maintainedMap, renderType } = useGameStore();
  const { token, info, websetConfig } = useUserInfoStore();
  const [showAll, setShowAll] = reactExports.useState(false);
  const rowItemLength = renderType === "rect" ? 3 : 4;
  const [state, setState] = useSetState({
    page: 1,
    list: [],
    page_size: 20,
    total: 0
  });
  const [isLoading, setIsLoading] = reactExports.useState(false);
  const hotShowBy = games ? games.find((item2) => item2.title === "热门") : {};
  const showBy = games ? JSON.parse(hotShowBy.show_by || "{}") : {};
  const len = renderType === "rect" ? showBy.sh || 10 : showBy.fh || 10;
  const getHotGameByQuery = async (page2 = 1) => {
    if (isLoading)
      return;
    setIsLoading(true);
    const [res] = await getHotGames(
      {
        page: page2,
        page_size: state.page_size
      },
      { useLoading: true }
    );
    setIsLoading(false);
    const d = res.d || [];
    const t = res.t || 0;
    const { list: list2, total: total2 } = state;
    setState({
      list: page2 == 1 ? d : list2.concat(d),
      page: page2,
      total: t || total2
    });
    if (page2 === 1) {
      useGameStore.setState({ hotGames: d });
    }
  };
  reactExports.useEffect(() => {
    getHotGameByQuery();
  }, []);
  const getPlatLaunchFun = async (id, code = "", game) => {
    if (game.is_lobby === 1 && platTypeIds.includes(+game.game_type)) {
      navigate("/venuegame?&id=".concat(game.game_type, "&pid=").concat(game.id || "0"));
      return;
    }
    if (!token) {
      useUserInfoStore.setState({ openForLogin: true });
      return;
    }
    const [res, error] = await getPlatLaunch(
      { id, code },
      { useLoading: true }
    );
    if (res) {
      Cache.set("gameStart", res);
      navigate("/gameStart");
      await historySave({ pid: id, code });
    }
  };
  const { list, total, page } = state;
  const [isEnlarged, setIsEnlarged] = reactExports.useState(false);
  const btnCollect = async (game) => {
    if (!token) {
      useUserInfoStore.setState({ openForLogin: true });
      return;
    }
    if (game.is_favorites) {
      const [res, err] = await favoritesremove({
        pid: game.platform_id,
        code: game.game_id
      });
      if (res) {
        list.map((item2, idx) => {
          if (item2.id === game.id) {
            list[idx].is_favorites = false;
          }
        });
        setState({
          list,
          page,
          total
        });
      }
    } else {
      const [res, err] = await favorites({
        pid: game.platform_id,
        code: game.game_id
      });
      if (res) {
        list.map((item2, idx) => {
          if (item2.id === game.id) {
            list[idx].is_favorites = true;
          }
        });
        setState({
          list,
          page,
          total
        });
      }
      setIsEnlarged(true);
    }
  };
  const limitClicks = () => {
    setShowAll(true);
    if (isLoading)
      return;
    getHotGameByQuery(page + 1);
  };
  const getRenderList = () => {
    if (showAll) {
      return list;
    }
    return list.slice(0, len * rowItemLength);
  };
  return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$4.itemBox, id: "Popular", children: !remote && /* @__PURE__ */ jsxRuntimeExports.jsxs(jsxRuntimeExports.Fragment, { children: [
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$4.topBarBox, children: /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$4.leftBox, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$4.icon, children: /* @__PURE__ */ jsxRuntimeExports.jsx(ActionHotIcon, { isSelect: true }) }),
      /* @__PURE__ */ jsxRuntimeExports.jsx("span", { children: instance.t(item.type) })
    ] }) }),
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$4.itemsContainer, style: { paddingBottom: list.length > 0 ? "20rem" : "0" }, children: getRenderList().map((game, idx) => {
      let isShow = (game == null ? void 0 : game.is_favorites) || false;
      let gameImg = game.img;
      if (renderType === "rect") {
        gameImg = game.img.replace("images-br", "images-br-rect");
      }
      if (renderType === "rect") {
        return /* @__PURE__ */ jsxRuntimeExports.jsx(
          RectGameItem,
          {
            gameNamesMap,
            maintainedMap,
            game,
            idx,
            getPlatLaunchFun,
            platTypeIds
          },
          idx
        );
      }
      return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$4.gameBox, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsxs(
          "div",
          {
            className: css$4.logoBox,
            onClick: () => {
              if (maintainedMap[game.platform_id] === 2 || game.maintained === 2)
                return;
              if (info && +info.balance < (+game.min_admission || 0)) {
                Message.error(instance.t("您的余额低于「最低准入金额」，请存款后才能玩", { amount: game.min_admission, coin: getMoneyUnit(true) }));
                return;
              }
              getPlatLaunchFun(game.platform_id, game.game_id, game);
            },
            children: [
              /* @__PURE__ */ jsxRuntimeExports.jsx(
                "div",
                {
                  onClick: (e) => {
                    e.stopPropagation();
                    btnCollect(game);
                  },
                  className: joinClass(
                    css$4.game_list_item_hots,
                    isEnlarged ? css$4.game_list_item_hots_active : ""
                  ),
                  children: isShow && /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { src: "/home/icons/collect_active2.webp" })
                }
              ),
              game.is_recommend === 1 && /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { className: css$4.game_recommend, src: "/home/icons/recommend.webp" }),
              /* @__PURE__ */ jsxRuntimeExports.jsx(
                Image,
                {
                  loading: /* @__PURE__ */ jsxRuntimeExports.jsx(LoadingImg, { className: css$4.laodingBox }),
                  isGame: true,
                  src: gameImg,
                  remote: true
                }
              ),
              maintainedMap[game.platform_id] === 2 || game.maintained === 2 ? /* @__PURE__ */ jsxRuntimeExports.jsx(Maintain, {}) : null
            ]
          }
        ),
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$4.nameBox, children: game.en_name })
      ] }, idx);
    }) }),
    getRenderList().length === total ? null : /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$4.btmLoadMoreBox, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: css$4.tips, children: instance.t("显示{{total}}款老虎机游戏中的{{num}}款游戏", {
        total: total || 0,
        num: getRenderList().length || 0
      }) }),
      total > getRenderList().length ? /* @__PURE__ */ jsxRuntimeExports.jsx(
        LoadMore,
        {
          className: css$4.loadMoreBtn,
          onClick: () => {
            limitClicks();
          }
        }
      ) : null
    ] })
  ] }) });
};
const RectGameItem = ({ gameNamesMap, maintainedMap, game, getPlatLaunchFun, idx }) => {
  const { renderType } = useGameStore();
  let gameImg = game.img;
  if (renderType === "rect") {
    gameImg = game.img.replace("images-br", "images-br-rect");
  }
  const [isShow, setIsShow] = reactExports.useState((game == null ? void 0 : game.is_favorites) || false);
  const [isEnlarged, setIsEnlarged] = reactExports.useState(false);
  const { token, websetConfig, info } = useUserInfoStore();
  websetConfig.game_recommend === "1";
  const btnCollect = async (game2) => {
    if (!token) {
      useUserInfoStore.setState({ openForLogin: true });
      return;
    }
    if (isShow) {
      const [res, err] = await favoritesremove({ pid: game2.platform_id, code: game2.game_id });
      if (res)
        setIsShow(false);
    } else {
      const [res, err] = await favorites({ pid: game2.platform_id, code: game2.game_id });
      if (res)
        setIsShow(true);
      setIsEnlarged(true);
    }
  };
  return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$5.gameBox, children: /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$5.logoBox, onClick: () => {
    if (maintainedMap[game.platform_id] === 2 || game.maintained === 2)
      return;
    if (info && +info.balance < (+game.min_admission || 0)) {
      Message.error(instance.t("您的余额低于「最低准入金额」，请存款后才能玩", { amount: game.min_admission, coin: getMoneyUnit(true) }));
      return;
    }
    getPlatLaunchFun(game.platform_id, game.game_id, game);
  }, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { onClick: (e) => {
      e.stopPropagation();
      btnCollect(game);
    }, className: joinClass(css$5.game_list_item_hots, isEnlarged ? css$5.game_list_item_hots_active : ""), children: isShow && /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { src: "/home/icons/collect_active2.webp" }) }),
    game.is_recommend === 1 && /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { className: css$5.game_recommend, src: "/home/icons/recommend.webp" }),
    /* @__PURE__ */ jsxRuntimeExports.jsx(
      Image,
      {
        loading: /* @__PURE__ */ jsxRuntimeExports.jsx(LoadingImg, { className: css$5.laodingBox }),
        isGame: true,
        src: gameImg,
        remote: true
      }
    ),
    maintainedMap[game.platform_id] === 2 || game.maintained === 2 ? /* @__PURE__ */ jsxRuntimeExports.jsx(Maintain, {}) : null,
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$5.gameBox_s, children: game.en_name })
  ] }) });
};
const HomeGameTypes = [
  {
    type: "Popular",
    icon: "hot_active.webp"
  }
];
const Games = () => {
  const { games } = useGameStore();
  const platformList = [];
  games.forEach((gameTypeobj) => {
    if (gameTypeobj.l && Array.isArray(gameTypeobj.l) && gameTypeobj.l.length > 0) {
      gameTypeobj.l.forEach((game) => {
        if (game.platform_is_hot === 1) {
          const obj = Object.assign(
            {},
            game,
            { prefix: gameTypeobj.prefix, level: gameTypeobj.level, typeName: gameTypeobj.name }
          );
          platformList.push(obj);
        }
      });
    }
  });
  platformList.sort((a, b) => {
    return b.seq - a.seq;
  });
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$6.gamesBox, children: [
    games.find((item) => item.title === "热门") ? HomeGameTypes.map((item, idx) => {
      return /* @__PURE__ */ jsxRuntimeExports.jsx(HotGameItem, { item }, idx);
    }) : "",
    games.filter((item) => item.title !== "热门").map((item, idx) => {
      if (item.l && Array.isArray(item.l) && item.l.length > 0) {
        return /* @__PURE__ */ jsxRuntimeExports.jsx(TypeGame, { item }, idx);
      }
    })
  ] });
};
const svg_theme_fill_color$3 = "_svg_theme_fill_color_7mtfm_3";
const homeContainer = "_homeContainer_7mtfm_55";
const contentBox = "_contentBox_7mtfm_140";
const download = "_download_7mtfm_152";
const css$3 = {
  svg_theme_fill_color: svg_theme_fill_color$3,
  homeContainer,
  contentBox,
  download
};
const svg_theme_fill_color$2 = "_svg_theme_fill_color_fbkoi_3";
const borderTop = "_borderTop_fbkoi_55";
const styl5Partner = "_styl5Partner_fbkoi_55";
const styl4Company = "_styl4Company_fbkoi_55";
const styl4Partner = "_styl4Partner_fbkoi_55";
const styl3Partner = "_styl3Partner_fbkoi_55";
const style2Company = "_style2Company_fbkoi_55";
const styl1Partner = "_styl1Partner_fbkoi_55";
const tipsBox = "_tipsBox_fbkoi_113";
const detailTip = "_detailTip_fbkoi_701";
const styl1Tips = "_styl1Tips_fbkoi_778";
const styl1Quick = "_styl1Quick_fbkoi_782";
const styl1Official = "_styl1Official_fbkoi_786";
const styl1Company = "_styl1Company_fbkoi_790";
const style2Tips = "_style2Tips_fbkoi_798";
const styl2Partner = "_styl2Partner_fbkoi_810";
const tips3List = "_tips3List_fbkoi_814";
const styl3Tips = "_styl3Tips_fbkoi_818";
const styl3Official = "_styl3Official_fbkoi_822";
const styl3Company = "_styl3Company_fbkoi_826";
const quick2Item = "_quick2Item_fbkoi_834";
const quick2Title = "_quick2Title_fbkoi_973";
const quick2List = "_quick2List_fbkoi_977";
const quick2ListItem = "_quick2ListItem_fbkoi_982";
const style4Tips = "_style4Tips_fbkoi_1064";
const styl4Quick = "_styl4Quick_fbkoi_1072";
const styl5Tips = "_styl5Tips_fbkoi_1086";
const styl5Quick = "_styl5Quick_fbkoi_1090";
const styl5Official = "_styl5Official_fbkoi_1095";
const style5Tips = "_style5Tips_fbkoi_1104";
const logoContainer = "_logoContainer_fbkoi_1113";
const logo = "_logo_fbkoi_475";
const css$2 = {
  svg_theme_fill_color: svg_theme_fill_color$2,
  borderTop,
  styl5Partner,
  styl4Company,
  styl4Partner,
  styl3Partner,
  style2Company,
  styl1Partner,
  tipsBox,
  detailTip,
  styl1Tips,
  styl1Quick,
  styl1Official,
  styl1Company,
  style2Tips,
  styl2Partner,
  tips3List,
  styl3Tips,
  styl3Official,
  styl3Company,
  quick2Item,
  quick2Title,
  quick2List,
  quick2ListItem,
  style4Tips,
  styl4Quick,
  styl5Tips,
  styl5Quick,
  styl5Official,
  style5Tips,
  logoContainer,
  logo
};
function useShowState() {
  const { websetConfig } = useUserInfoStore();
  const state = useReactive({
    /** 快速跳转开关 */
    quickNavigateToggle: false,
    /** 分享设置开关 */
    shareSettingsToggle: false,
    /** 官方频道或社区开关 */
    officialChannelToggle: false,
    /** 合作方信息开关 */
    partnerInfoToggle: false,
    /** 牌照资质开关 */
    licenseToggle: false
  });
  reactExports.useEffect(() => {
    if (websetConfig) {
      const footerJson = JSON.parse(websetConfig.footerJson || "{}");
      state.quickNavigateToggle = footerJson.quickNavigateToggle === "1";
      state.shareSettingsToggle = footerJson.shareSettingsToggle === "1";
      state.officialChannelToggle = footerJson.officialChannelToggle === "1";
      state.partnerInfoToggle = footerJson.partnerInfoToggle === "1";
      state.licenseToggle = footerJson.licenseToggle === "1";
    }
  }, [websetConfig]);
  return state;
}
const QuickEntry = ({ style = 1 }) => {
  const { websetConfig } = useUserInfoStore();
  const navigate = useNavigate();
  const state = useReactive({
    mapList: [
      {
        title: "Cassino",
        child: [
          {
            title: "Activity",
            value: "活动",
            path: "/activity"
          },
          {
            title: "mission",
            value: "任务中心",
            path: "/missao"
          },
          {
            title: "返水",
            value: "返水",
            path: "/back-rate"
          },
          {
            title: "Pending",
            value: "待领取",
            path: "/bonus"
          },
          {
            title: "VIP",
            value: "VIP",
            path: "/vip"
          },
          {
            title: "Agent",
            value: "邀请/代理",
            path: "/agent"
          },
          {
            title: "Historic",
            value: "历史",
            path: "/alreadyGetbonus"
          }
        ]
      },
      {
        title: "游戏",
        child: [
          {
            title: "LIVE",
            value: "真人",
            id: "label_Cartas",
            gametype: "真人"
          },
          {
            title: "捕鱼",
            value: "捕鱼",
            id: "label_Pescaria",
            gametype: "捕鱼"
          },
          {
            title: "电子",
            value: "电子",
            id: "label_Slots",
            gametype: "电子"
          },
          {
            title: "体育",
            // 11
            value: "体育",
            id: "label_Esporte",
            gametype: "体育"
          },
          {
            title: "棋牌",
            value: "棋牌",
            id: "label_Cartas",
            gametype: "棋牌"
          },
          {
            title: "电竞",
            value: "电竞",
            id: "label_Esports",
            gametype: "电竞"
          },
          {
            title: "彩票",
            value: "彩票",
            id: "label_Loteria",
            gametype: "彩票"
          },
          {
            title: "斗鸡",
            value: "斗鸡",
            id: "label_douji",
            gametype: "斗鸡"
          },
          {
            title: "小游戏",
            value: "小游戏",
            id: "label_Blockchain",
            gametype: "小游戏"
          }
        ]
      },
      {
        title: "帮助",
        child: [
          {
            title: "在线客服",
            value: "在线客服",
            path: "/message?service=1"
          },
          {
            title: "帮助中心",
            value: "帮助中心",
            path: ""
          },
          {
            title: "有奖反馈",
            value: "有奖反馈",
            path: ""
          },
          {
            title: "about",
            value: "关于我们",
            path: ""
          }
        ]
      }
    ]
  });
  function handleClcik(item) {
    if (item.title === "Suporte online") {
      const url = Cache.get("services_url") || "";
      if (!url) {
        Message.error(trans("暂无客服"));
        return;
      }
      window.open(url, "_blank");
      return;
    }
    if (item.path) {
      navigate(item.path);
      if (item.gametype) {
        useGameStore.setState({
          selectType: item.gametype
        });
      }
    } else {
      const dom = document.getElementById(item.id);
      if (!dom)
        return;
      dom.click();
    }
  }
  reactExports.useEffect(() => {
    if (websetConfig) {
      const footerJson = JSON.parse(websetConfig.footerJson || "{}");
      const list1Str = footerJson.cassinoAry || "";
      const list2Str = footerJson.gameAry || "";
      const list3Str = footerJson.suporteAry || "";
      state.mapList[0].child = state.mapList[0].child.filter((item) => list1Str.includes(item.value));
      state.mapList[1].child = state.mapList[1].child.filter((item) => list2Str.includes(item.value));
      state.mapList[2].child = state.mapList[2].child.filter((item) => list3Str.includes(item.value));
    }
  }, [websetConfig]);
  return /* @__PURE__ */ jsxRuntimeExports.jsx(jsxRuntimeExports.Fragment, { children: style === 1 ? /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "maps_list", children: state.mapList.map((col) => {
    return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: "maps_list_col", children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "map_list_col_title", children: instance.t(col.title) }),
      col.child.map((item) => {
        return /* @__PURE__ */ jsxRuntimeExports.jsx(
          "div",
          {
            className: "button itemTitle",
            onClick: () => {
              handleClcik(item);
            },
            children: instance.t(item.title)
          },
          item.title
        );
      })
    ] }, col.title);
  }) }) : /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.quick2Container, children: state.mapList.map((pItem, i) => {
    return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$2.quick2Item, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.quick2Title, children: instance.t(pItem.title) }),
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.quick2List, children: pItem.child.map((item, index) => {
        return /* @__PURE__ */ jsxRuntimeExports.jsx(
          "div",
          {
            className: css$2.quick2ListItem,
            onClick: () => {
              handleClcik(item);
            },
            children: instance.t(item.title)
          },
          index
        );
      }) })
    ] }, pItem.title);
  }) }) });
};
const Contact = () => {
  const { agentUrl } = useUserInfoStore();
  const { share } = useFloatPopShareStore();
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: "img_list", children: [
    /* @__PURE__ */ jsxRuntimeExports.jsx("p", { className: "img_list_title", children: trans("与我们联系") }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: "img_list_flex", children: [
      share == null ? void 0 : share.map((item, index) => {
        const link = item.link.replace("xxxxx", encodeURIComponent(agentUrl));
        return /* @__PURE__ */ jsxRuntimeExports.jsx(
          Image,
          {
            className: "button",
            remote: true,
            isGame: true,
            src: item.img,
            onClick: () => {
              console.log("share link :>> ", link);
              clipboardExports.copy(agentUrl);
              window.open(link, "_blank");
            }
          },
          index
        );
      }),
      /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { className: "button", src: "/home/icons/18_.webp" })
    ] })
  ] });
};
const OfficialChannel = () => {
  const { websetConfig } = useUserInfoStore();
  const [threeLoginList, setThreeLoginList] = reactExports.useState([]);
  const [threeLoginShow, setThreeLoginShow] = reactExports.useState(false);
  reactExports.useEffect(() => {
    if (websetConfig) {
      const arr = JSON.parse((websetConfig == null ? void 0 : websetConfig.official_channels) || "[]");
      setThreeLoginShow(!!arr.length);
      setThreeLoginList(arr.sort((a, b) => a.sort - b.sort));
    }
  }, [websetConfig]);
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: "img_list", children: [
    threeLoginShow && /* @__PURE__ */ jsxRuntimeExports.jsx("p", { className: "img_list_title", children: trans("官方频道") }),
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "img_list_flex img_canal_oficial", children: threeLoginList == null ? void 0 : threeLoginList.map((item, index) => {
      return /* @__PURE__ */ jsxRuntimeExports.jsx(
        Image,
        {
          className: "button",
          src: item.icon,
          remote: true,
          isGame: true,
          onClick: () => {
            window.open(item.link, "_blank");
          }
        },
        index
      );
    }) })
  ] });
};
const CompanyInfo = () => {
  const { websetConfig } = useUserInfoStore();
  const footerJson = JSON.parse((websetConfig == null ? void 0 : websetConfig.footerJson) || "{}");
  return /* @__PURE__ */ jsxRuntimeExports.jsx(
    "div",
    {
      className: css$2.detailTip,
      dangerouslySetInnerHTML: { __html: footerJson.companyInfoHtml }
    }
  );
};
const PartnerInfo = () => {
  const { websetConfig } = useUserInfoStore();
  const {
    partnerInfoToggle,
    licenseToggle
  } = useShowState();
  const state = useReactive({
    partnerInfoData: [],
    licenseInfo: []
  });
  reactExports.useEffect(() => {
    if (websetConfig) {
      try {
        const footerJson = JSON.parse(websetConfig.footerJson || "{}");
        state.partnerInfoData = footerJson.partnerInfoData || [];
        state.licenseInfo = footerJson.licenseInfo || [];
      } catch (error) {
        console.error("合作方信息解析失败", error);
      }
    }
  }, [websetConfig]);
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: "tip_bottom", children: [
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "logos_1", children: partnerInfoToggle && state.partnerInfoData.map((item, index) => {
      return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "logos_2_item", children: /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { src: item.image, remote: true, isGame: true }) }, index);
    }) }),
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "logos_1 logos_2", children: licenseToggle && state.licenseInfo.map((item, index) => {
      return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "logos_2_item logos_3_item", children: /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { src: item.image, remote: true, isGame: true }) }, index);
    }) })
  ] });
};
const Reserved = () => {
  const { websetConfig } = useUserInfoStore();
  const state = useReactive({
    list: []
  });
  reactExports.useEffect(() => {
    if (websetConfig) {
      const footerJson = JSON.parse(websetConfig.footerJson || "{}");
      const _copyrightInfo = footerJson.copyrightInfo || "[]";
      const copyrightInfo = _copyrightInfo;
      if (copyrightInfo && Array.isArray(copyrightInfo)) {
        const arr = [];
        for (let i = 0; i < Math.ceil(copyrightInfo.length / 2); i++) {
          arr.push([copyrightInfo[i * 2], copyrightInfo[i * 2 + 1]]);
        }
        state.list = arr;
      }
    }
  }, [websetConfig]);
  return /* @__PURE__ */ jsxRuntimeExports.jsx(jsxRuntimeExports.Fragment, { children: state.list.map((item, index) => {
    return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: "reserved", children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx("p", { className: "group_name", dangerouslySetInnerHTML: {
        __html: item[0].replace(/\n/g, "<br>")
      } }),
      item[1] && /* @__PURE__ */ jsxRuntimeExports.jsxs(jsxRuntimeExports.Fragment, { children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx("p", { className: "group_line" }),
        /* @__PURE__ */ jsxRuntimeExports.jsxs("p", { className: "group_all", children: [
          " ",
          item[1],
          " "
        ] })
      ] })
    ] }, index);
  }) });
};
const Style1 = () => {
  const { websetConfig: websetConfigByHook } = useWebsetConfig();
  const {
    quickNavigateToggle,
    shareSettingsToggle,
    officialChannelToggle,
    partnerInfoToggle,
    licenseToggle
  } = useShowState();
  return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.tipsBox, children: /* @__PURE__ */ jsxRuntimeExports.jsxs(
    "div",
    {
      className: joinClass(
        "containerBox",
        !websetConfigByHook.isHiddenDownloadApp ? "bottomMoveDown" : ""
      ),
      children: [
        quickNavigateToggle && /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.styl1Quick, children: /* @__PURE__ */ jsxRuntimeExports.jsx(QuickEntry, {}) }),
        shareSettingsToggle || officialChannelToggle ? /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: "tips_list", children: [
          shareSettingsToggle && /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.styl1Tips, children: /* @__PURE__ */ jsxRuntimeExports.jsx(Contact, {}) }),
          officialChannelToggle && /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.styl1Official, children: /* @__PURE__ */ jsxRuntimeExports.jsx(OfficialChannel, {}) })
        ] }) : null,
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.styl1Company, children: /* @__PURE__ */ jsxRuntimeExports.jsx(CompanyInfo, {}) }),
        partnerInfoToggle || licenseToggle ? /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.styl1Partner, children: /* @__PURE__ */ jsxRuntimeExports.jsx(PartnerInfo, {}) }) : null,
        /* @__PURE__ */ jsxRuntimeExports.jsx(Reserved, {})
      ]
    }
  ) });
};
const Style2 = () => {
  const { websetConfig } = useUserInfoStore();
  const { websetConfig: websetConfigByHook } = useWebsetConfig();
  const officialChannels = JSON.parse((websetConfig == null ? void 0 : websetConfig.official_channels) || "[]");
  const {
    shareSettingsToggle,
    officialChannelToggle,
    partnerInfoToggle,
    licenseToggle
  } = useShowState();
  return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.tipsBox, children: /* @__PURE__ */ jsxRuntimeExports.jsxs(
    "div",
    {
      className: joinClass(
        "containerBox",
        !websetConfigByHook.isHiddenDownloadApp ? "bottomMoveDown" : ""
      ),
      children: [
        shareSettingsToggle || officialChannelToggle ? /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: "".concat(css$2.style2Tips, " tips_list"), children: [
          shareSettingsToggle && /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: /* @__PURE__ */ jsxRuntimeExports.jsx(Contact, {}) }),
          officialChannelToggle && officialChannels.length !== 0 && /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: /* @__PURE__ */ jsxRuntimeExports.jsx(OfficialChannel, {}) })
        ] }) : null,
        partnerInfoToggle || licenseToggle ? /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.styl2Partner, children: /* @__PURE__ */ jsxRuntimeExports.jsx(PartnerInfo, {}) }) : null,
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.style2Company, children: /* @__PURE__ */ jsxRuntimeExports.jsx(CompanyInfo, {}) }),
        /* @__PURE__ */ jsxRuntimeExports.jsx(Reserved, {})
      ]
    }
  ) });
};
const Style3 = () => {
  const { websetConfig: websetConfigByHook } = useWebsetConfig();
  const {
    quickNavigateToggle,
    shareSettingsToggle,
    officialChannelToggle,
    partnerInfoToggle,
    licenseToggle
  } = useShowState();
  return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.tipsBox, children: /* @__PURE__ */ jsxRuntimeExports.jsxs(
    "div",
    {
      className: joinClass(
        "containerBox",
        !websetConfigByHook.isHiddenDownloadApp ? "bottomMoveDown" : ""
      ),
      children: [
        shareSettingsToggle || officialChannelToggle ? /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: "".concat(css$2.tips3List, " tips_list"), children: [
          shareSettingsToggle && /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.styl3Tips, children: /* @__PURE__ */ jsxRuntimeExports.jsx(Contact, {}) }),
          officialChannelToggle && /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.styl3Official, children: /* @__PURE__ */ jsxRuntimeExports.jsx(OfficialChannel, {}) })
        ] }) : null,
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.styl3Company, children: /* @__PURE__ */ jsxRuntimeExports.jsx(CompanyInfo, {}) }),
        quickNavigateToggle && /* @__PURE__ */ jsxRuntimeExports.jsx(QuickEntry, { style: 2 }),
        partnerInfoToggle || licenseToggle ? /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.styl3Partner, children: /* @__PURE__ */ jsxRuntimeExports.jsx(PartnerInfo, {}) }) : null,
        /* @__PURE__ */ jsxRuntimeExports.jsx(Reserved, {})
      ]
    }
  ) });
};
const Style4 = () => {
  const { websetConfig } = useUserInfoStore();
  const { websetConfig: websetConfigByHook } = useWebsetConfig();
  const officialChannels = JSON.parse((websetConfig == null ? void 0 : websetConfig.official_channels) || "[]");
  const {
    quickNavigateToggle,
    shareSettingsToggle,
    officialChannelToggle,
    partnerInfoToggle,
    licenseToggle
  } = useShowState();
  return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.tipsBox, children: /* @__PURE__ */ jsxRuntimeExports.jsxs(
    "div",
    {
      className: joinClass(
        "containerBox",
        !websetConfigByHook.isHiddenDownloadApp ? "bottomMoveDown" : ""
      ),
      children: [
        quickNavigateToggle && /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.styl4Quick, children: /* @__PURE__ */ jsxRuntimeExports.jsx(QuickEntry, {}) }),
        shareSettingsToggle || officialChannelToggle ? /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: "".concat(css$2.style4Tips, " tips_list"), children: [
          shareSettingsToggle && /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: /* @__PURE__ */ jsxRuntimeExports.jsx(Contact, {}) }),
          officialChannelToggle && officialChannels.length !== 0 && /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: /* @__PURE__ */ jsxRuntimeExports.jsx(OfficialChannel, {}) })
        ] }) : null,
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.styl4Company, children: /* @__PURE__ */ jsxRuntimeExports.jsx(CompanyInfo, {}) }),
        partnerInfoToggle || licenseToggle ? /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.styl4Partner, children: /* @__PURE__ */ jsxRuntimeExports.jsx(PartnerInfo, {}) }) : null,
        /* @__PURE__ */ jsxRuntimeExports.jsx(Reserved, {})
      ]
    }
  ) });
};
const Style5 = () => {
  const navigate = useNavigate();
  const { websetConfig } = useUserInfoStore();
  const { websetConfig: websetConfigByHook } = useWebsetConfig();
  const officialChannels = JSON.parse((websetConfig == null ? void 0 : websetConfig.official_channels) || "[]");
  const {
    quickNavigateToggle,
    shareSettingsToggle,
    officialChannelToggle,
    partnerInfoToggle,
    licenseToggle
  } = useShowState();
  return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.tipsBox, children: /* @__PURE__ */ jsxRuntimeExports.jsxs(
    "div",
    {
      className: joinClass(
        "containerBox",
        !websetConfigByHook.isHiddenDownloadApp ? "bottomMoveDown" : ""
      ),
      children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.logoContainer, children: /* @__PURE__ */ jsxRuntimeExports.jsx(
          Image,
          {
            src: websetConfigByHook.logo_img,
            onClick: () => navigate("/"),
            className: css$2.logo,
            remote: true,
            isGame: true
          }
        ) }),
        /* @__PURE__ */ jsxRuntimeExports.jsx(CompanyInfo, {}),
        quickNavigateToggle && /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.styl5Quick, children: /* @__PURE__ */ jsxRuntimeExports.jsx(QuickEntry, {}) }),
        shareSettingsToggle || officialChannelToggle ? /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: "".concat(css$2.style5Tips, " tips_list"), children: [
          officialChannelToggle && officialChannels.length !== 0 && /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: /* @__PURE__ */ jsxRuntimeExports.jsx(OfficialChannel, {}) }),
          shareSettingsToggle && /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: /* @__PURE__ */ jsxRuntimeExports.jsx(Contact, {}) })
        ] }) : null,
        partnerInfoToggle || licenseToggle ? /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.styl5Partner, children: /* @__PURE__ */ jsxRuntimeExports.jsx(PartnerInfo, {}) }) : null,
        /* @__PURE__ */ jsxRuntimeExports.jsx(Reserved, {})
      ]
    }
  ) });
};
const BottomTips = () => {
  const { websetConfig } = useUserInfoStore();
  const footerJson = JSON.parse((websetConfig == null ? void 0 : websetConfig.footerJson) || "{}");
  const styleNum = footerJson.styleDisplay;
  return /* @__PURE__ */ jsxRuntimeExports.jsxs(jsxRuntimeExports.Fragment, { children: [
    styleNum === "1" && /* @__PURE__ */ jsxRuntimeExports.jsx(Style1, {}),
    styleNum === "2" && /* @__PURE__ */ jsxRuntimeExports.jsx(Style2, {}),
    styleNum === "3" && /* @__PURE__ */ jsxRuntimeExports.jsx(Style3, {}),
    styleNum === "4" && /* @__PURE__ */ jsxRuntimeExports.jsx(Style4, {}),
    styleNum === "5" && /* @__PURE__ */ jsxRuntimeExports.jsx(Style5, {})
  ] });
};
const svg_theme_fill_color$1 = "_svg_theme_fill_color_1ojhd_3";
const typeGameBox$1 = "_typeGameBox_1ojhd_55";
const headBox$1 = "_headBox_1ojhd_55";
const leftBox$1 = "_leftBox_1ojhd_65";
const icon$1 = "_icon_1ojhd_71";
const platformLogo$1 = "_platformLogo_1ojhd_83";
const rightBox$1 = "_rightBox_1ojhd_123";
const gameBoxs$1 = "_gameBoxs_1ojhd_185";
const gameBox$1 = "_gameBox_1ojhd_185";
const logoBox$1 = "_logoBox_1ojhd_197";
const laodingBox$1 = "_laodingBox_1ojhd_207";
const game_list_item_hots$1 = "_game_list_item_hots_1ojhd_288";
const gameBox_s$1 = "_gameBox_s_1ojhd_299";
const platformText$1 = "_platformText_1ojhd_314";
const empty$1 = "_empty_1ojhd_326";
const emptyText$1 = "_emptyText_1ojhd_340";
const css$1 = {
  svg_theme_fill_color: svg_theme_fill_color$1,
  typeGameBox: typeGameBox$1,
  headBox: headBox$1,
  leftBox: leftBox$1,
  icon: icon$1,
  platformLogo: platformLogo$1,
  rightBox: rightBox$1,
  gameBoxs: gameBoxs$1,
  gameBox: gameBox$1,
  logoBox: logoBox$1,
  laodingBox: laodingBox$1,
  game_list_item_hots: game_list_item_hots$1,
  gameBox_s: gameBox_s$1,
  platformText: platformText$1,
  empty: empty$1,
  emptyText: emptyText$1
};
const Collect = (props = {}) => {
  const initState = {
    pid: "0",
    flag: 0,
    keyword: ""
  };
  const [listState, updateListState] = reactExports.useState(initState);
  const navigate = useNavigate();
  const { token, info } = useUserInfoStore();
  const item = props.item || null;
  if (!item)
    return;
  const [list, setList] = reactExports.useState([]);
  const [searchList, setSearchList] = reactExports.useState([]);
  async function getGame() {
    if (!token) {
      useUserInfoStore.setState({ openForLogin: true });
      return;
    }
    const [result] = await favoritesList();
    setList((result == null ? void 0 : result.d) || []);
    setSearchList((result == null ? void 0 : result.d) || []);
  }
  reactExports.useEffect(() => {
    getGame();
  }, [item]);
  const tabItem = GameTabs$1.find((tabItem2) => {
    return tabItem2.type && tabItem2.type === item;
  }) || null;
  if (!tabItem)
    return;
  const getPlatLaunchFun = async (id, codeId = "") => {
    if (!token) {
      useUserInfoStore.setState({ openForLogin: true });
      return;
    }
    const [res, error] = await getPlatLaunch(
      { id, code: codeId },
      { useLoading: true }
    );
    if (res) {
      Cache.set("gameStart", res);
      navigate("/gameStart");
      await historySave({ pid: id, code: codeId });
    }
  };
  const IconsCom = tabItem.ActiveIcon || null;
  const { gameNamesMap, maintainedMap } = useGameStore();
  const btnCollect = async (game) => {
    const filterItem = list.filter((item2) => item2.id != game.id);
    const [res, err] = await favoritesremove({
      pid: game.platform_id,
      code: game.game_id
    });
    if (res)
      setList(filterItem);
  };
  const handleInput = (val) => {
    updateListState({
      ...listState,
      keyword: val
    });
  };
  const handleSearch = () => {
    let regex = new RegExp(listState.keyword);
    let searchResult = searchList.filter((item2) => regex.test(item2.en_name));
    setList(searchResult || []);
  };
  const { theme } = useUserInfoStore();
  const gameEmpty = {
    whiteRed: "/home/icons/game_empty_whiteRed.webp",
    versaceYellow: "/home/icons/game_empty_versaceYellow.webp",
    lancomePeach: "/home/icons/game_empty_lancomePeach.webp",
    hermesOrange: "/home/icons/game_empty_hermesOrange.webp",
    whiteBlue: "/home/icons/game_empty_whiteBlue.webp",
    sk2: "/home/icons/game_empty_sk2.webp",
    whiteYellow: "/home/icons/game_empty_whiteRed.webp",
    lightBrown: "/home/icons/game_empty_lightBrown.webp",
    whiteOrange: "/home/icons/empty_icon_whiteOrange.webp",
    furlaBlue: "/home/icons/empty_icon_furlaBlue.webp",
    whitePink: "/home/icons/empty_icon_whitePink.webp",
    bvGreen: "/home/icons/empty_icon_bvGreen.webp",
    whiteBrown: "/home/icons/empty_icon_whiteBrown.webp",
    AnnaSuiPurple: "/home/icons/empty_icon_AnnaSuiPurple.webp",
    whitePurple: "/home/icons/empty_icon_whiteBrown.webp",
    burgundyRed: "/home/icons/empty_icon_burgundyRed.webp",
    whiteDarkGreen: "/home/icons/empty_icon_whiteDarkGreen.webp",
    greenGold: "/home/icons/empty_icon_greenGold.webp"
  };
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.typeGameBox, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsx(
      SearchInput,
      {
        value: listState.keyword,
        placeholder: instance.t("搜索游戏"),
        onInput: handleInput,
        onSearch: handleSearch
      }
    ),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.headBox, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.leftBox, children: [
        IconsCom ? /* @__PURE__ */ jsxRuntimeExports.jsx(IconsCom, { isSelect: true, className: css$1.icon }) : null,
        /* @__PURE__ */ jsxRuntimeExports.jsx("span", { children: instance.t(tabItem.text) })
      ] }),
      list.length > 0 && /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$1.rightBox, children: instance.t("全部") })
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.gameBoxs, children: [
      list.map((game, idx) => {
        const gameImg = game.img.replace("images-br/", "images-br-rect/");
        return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$1.gameBox, children: /* @__PURE__ */ jsxRuntimeExports.jsxs(
          "div",
          {
            className: css$1.logoBox,
            onClick: () => {
              if (maintainedMap[game.platform_id] === 2 || game.maintained === 2)
                return;
              if (info && +info.balance < (+game.min_admission || 0)) {
                Message.error(instance.t("您的余额低于「最低准入金额」，请存款后才能玩", { amount: game.min_admission, coin: getMoneyUnit(true) }));
                return;
              }
              getPlatLaunchFun(game.platform_id, game.game_id);
            },
            children: [
              /* @__PURE__ */ jsxRuntimeExports.jsx(
                "div",
                {
                  onClick: (e) => {
                    e.stopPropagation();
                    btnCollect(game);
                  },
                  className: css$1.game_list_item_hots,
                  children: /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { src: "/home/icons/ic_Favoritos_y.webp" })
                }
              ),
              /* @__PURE__ */ jsxRuntimeExports.jsx(
                Image,
                {
                  loading: /* @__PURE__ */ jsxRuntimeExports.jsx(LoadingImg, { className: css$1.laodingBox }),
                  isGame: true,
                  src: gameImg,
                  remote: true
                }
              ),
              maintainedMap[game.platform_id] === 2 || game.maintained === 2 ? /* @__PURE__ */ jsxRuntimeExports.jsx(Maintain, {}) : null,
              /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$1.gameBox_s, children: game.en_name }),
              /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$1.platformText, children: gameNamesMap[game.platform_id] || "" })
            ]
          }
        ) }, idx);
      }),
      list.length === 0 && /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.empty, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { src: gameEmpty[theme] || "/home/icons/game_empty.webp" }),
        /* @__PURE__ */ jsxRuntimeExports.jsx("p", { className: css$1.emptyText, children: instance.t("没有数据") })
      ] })
    ] })
  ] });
};
const svg_theme_fill_color = "_svg_theme_fill_color_tpppt_3";
const typeGameBox = "_typeGameBox_tpppt_55";
const headBox = "_headBox_tpppt_55";
const leftBox = "_leftBox_tpppt_65";
const icon = "_icon_tpppt_71";
const platformLogo = "_platformLogo_tpppt_83";
const lengtText = "_lengtText_tpppt_126";
const rightBox = "_rightBox_tpppt_129";
const gameBoxs = "_gameBoxs_tpppt_189";
const gameBox = "_gameBox_tpppt_189";
const logoBox = "_logoBox_tpppt_201";
const laodingBox = "_laodingBox_tpppt_211";
const game_list_item_hots = "_game_list_item_hots_tpppt_292";
const gameBox_s = "_gameBox_s_tpppt_303";
const platformText = "_platformText_tpppt_318";
const empty = "_empty_tpppt_333";
const emptyText = "_emptyText_tpppt_347";
const css = {
  svg_theme_fill_color,
  typeGameBox,
  headBox,
  leftBox,
  icon,
  platformLogo,
  lengtText,
  rightBox,
  gameBoxs,
  gameBox,
  logoBox,
  laodingBox,
  game_list_item_hots,
  gameBox_s,
  platformText,
  empty,
  emptyText
};
const Rcent = (props = {}) => {
  const initState = {
    pid: "0",
    flag: 0,
    keyword: ""
  };
  const [listState, updateListState] = reactExports.useState(initState);
  const navigate = useNavigate();
  const { token } = useUserInfoStore();
  const item = props.item || null;
  if (!item)
    return;
  const [list, setList] = reactExports.useState([]);
  const [searchList, setSearchList] = reactExports.useState([]);
  async function getGame() {
    if (!token) {
      useUserInfoStore.setState({ openForLogin: true });
      return;
    }
    const [result] = await historyList();
    setList((result == null ? void 0 : result.d) || []);
    setSearchList((result == null ? void 0 : result.d) || []);
  }
  reactExports.useEffect(() => {
    getGame();
  }, [item]);
  const tabItem = GameTabs$1.find((tabItem2) => {
    return tabItem2.type && tabItem2.type === item;
  }) || null;
  if (!tabItem)
    return;
  const getPlatLaunchFun = async (id, codeId = "") => {
    if (!token) {
      useUserInfoStore.setState({ openForLogin: true });
      return;
    }
    const [res, error] = await getPlatLaunch(
      { id, code: codeId },
      { useLoading: true }
    );
    if (res) {
      Cache.set("gameStart", res);
      navigate("/gameStart");
      await historySave({ pid: id, code: codeId });
    }
  };
  const IconsCom = tabItem.ActiveIcon || null;
  const { gameNamesMap, maintainedMap } = useGameStore();
  const handleInput = (val) => {
    updateListState({
      ...listState,
      keyword: val
    });
  };
  const handleSearch = () => {
    let regex = new RegExp(listState.keyword);
    let searchResult = searchList.filter((item2) => regex.test(item2.en_name));
    setList(searchResult || []);
  };
  const { theme } = useUserInfoStore();
  const gameEmpty = {
    whiteRed: "/home/icons/game_empty_whiteRed.webp",
    versaceYellow: "/home/icons/game_empty_versaceYellow.webp",
    lancomePeach: "/home/icons/game_empty_lancomePeach.webp",
    hermesOrange: "/home/icons/game_empty_hermesOrange.webp",
    whiteBlue: "/home/icons/game_empty_whiteBlue.webp",
    sk2: "/home/icons/game_empty_sk2.webp",
    whiteYellow: "/home/icons/game_empty_whiteRed.webp",
    lightBrown: "/home/icons/game_empty_lightBrown.webp",
    whiteOrange: "/home/icons/empty_icon_whiteOrange.webp",
    furlaBlue: "/home/icons/empty_icon_furlaBlue.webp",
    whitePink: "/home/icons/empty_icon_whitePink.webp",
    bvGreen: "/home/icons/empty_icon_bvGreen.webp",
    whiteBrown: "/home/icons/empty_icon_whiteBrown.webp",
    AnnaSuiPurple: "/home/icons/empty_icon_AnnaSuiPurple.webp",
    whitePurple: "/home/icons/empty_icon_whiteBrown.webp",
    burgundyRed: "/home/icons/empty_icon_burgundyRed.webp",
    whiteDarkGreen: "/home/icons/empty_icon_whiteDarkGreen.webp",
    greenGold: "/home/icons/empty_icon_greenGold.webp"
  };
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.typeGameBox, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsx(
      SearchInput,
      {
        value: listState.keyword,
        placeholder: instance.t("搜索游戏"),
        onInput: handleInput,
        onSearch: handleSearch
      }
    ),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.headBox, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.leftBox, children: [
        IconsCom ? /* @__PURE__ */ jsxRuntimeExports.jsx(IconsCom, { isSelect: true, className: css.icon }) : null,
        /* @__PURE__ */ jsxRuntimeExports.jsx("span", { children: instance.t(tabItem.text) })
      ] }),
      list.length > 0 && /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.rightBox, children: instance.t("Tudo") })
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.gameBoxs, children: [
      list.map((game, idx) => {
        return /* @__PURE__ */ jsxRuntimeExports.jsx(
          RectGameItem,
          {
            game,
            maintainedMap,
            getPlatLaunchFun,
            gameNamesMap
          },
          idx
        );
      }),
      list.length === 0 && /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.empty, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { src: gameEmpty[theme] || "/home/icons/game_empty.webp" }),
        /* @__PURE__ */ jsxRuntimeExports.jsx("p", { className: css.emptyText, children: instance.t("没有数据") })
      ] })
    ] })
  ] });
};
const platDomTopList = [];
const domScrollHandle = (e) => {
  if (window.clickTabing) {
    return;
  }
  const gameTabsBox2 = document.getElementById("gameTabsBox");
  const downloadDom = document.getElementById("downloadDom");
  const headerBoxDom = document.getElementById("headerBoxDom");
  const gameTabsBoxHeight = gameTabsBox2 ? gameTabsBox2.offsetHeight : 0;
  const downloadDomHeight = downloadDom ? downloadDom.offsetHeight : 0;
  const headerBoxDomHeight = headerBoxDom ? headerBoxDom.offsetHeight : 0;
  if (platDomTopList.length === 0) {
    for (let i = 0; i < GameTabs$1.length; i++) {
      const dom = document.getElementById(GameTabs$1[i].text);
      if (!dom) {
        continue;
      }
      platDomTopList.push({
        text: GameTabs$1[i].text,
        type: GameTabs$1[i].type,
        top: dom.offsetTop
      });
    }
    return;
  }
  const _scrollTop = e.target.scrollTop + gameTabsBoxHeight + downloadDomHeight + headerBoxDomHeight;
  let _index = 0;
  for (let i = 0; i < platDomTopList.length; i++) {
    if (_scrollTop >= platDomTopList[i].top) {
      _index = i;
    }
  }
  const _type = platDomTopList[_index].type;
  useGameStore.setState({ selectType: _type });
};
const Home = () => {
  const { selectType, games } = useGameStore();
  const { websetConfig } = useWebsetConfig();
  reactExports.useEffect(() => {
    const scrollDom = document.getElementById("homeBoxScroll");
    scrollDom.addEventListener("scroll", domScrollHandle);
    return () => {
      scrollDom.removeEventListener("scroll", domScrollHandle);
    };
  }, []);
  return /* @__PURE__ */ jsxRuntimeExports.jsx(jsxRuntimeExports.Fragment, { children: /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$3.homeContainer, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsx(Header, {}),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$3.contentBox, id: "homeBoxScroll", children: [
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { id: "h5ScrollContainer", children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx(Carousel, {}),
        /* @__PURE__ */ jsxRuntimeExports.jsx(Notice, {})
      ] }),
      /* @__PURE__ */ jsxRuntimeExports.jsx(GameTabs, {}),
      ["收藏", "最近"].indexOf(selectType) === -1 ? /* @__PURE__ */ jsxRuntimeExports.jsx(Jackpot, { isShow: websetConfig.pool_switch }) : null,
      ["收藏"].indexOf(selectType) > -1 ? /* @__PURE__ */ jsxRuntimeExports.jsx(Collect, { item: selectType }) : null,
      ["最近"].indexOf(selectType) > -1 ? /* @__PURE__ */ jsxRuntimeExports.jsx(Rcent, { item: selectType }) : null,
      ["收藏", "最近"].indexOf(selectType) === -1 ? /* @__PURE__ */ jsxRuntimeExports.jsx(Games, {}) : null,
      /* @__PURE__ */ jsxRuntimeExports.jsx(BottomTips, {})
    ] })
  ] }) });
};
export {
  Home as default
};
