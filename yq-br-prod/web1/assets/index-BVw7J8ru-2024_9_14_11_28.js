import { r as reactExports, N as jsxRuntimeExports, Q as joinClass, V as css$e, v as useUserInfoStore, E as useGameStore, A as useNavigate, ba as useGuideStore, S as Image, Y as instance, ae as getCountryFlag, ab as customToFixed, T as trans, al as events, W as Modal, w as browser, P as useReactive, bd as getBanner, a2 as minPxChip, b2 as getBrowser, F as useMessageStore, H as getMoneyUnit, be as useInViewport, b0 as sortGameTabs, b1 as scrollToPlatromItem, bf as getAwardAmount, a9 as Message, bg as getHotGames, bh as getPlatLaunch, J as Cache, bi as historySave, bj as favoritesremove, bk as favorites, aD as useFloatPopShareStore, bl as favoritesList, bm as historyList } from "./index-CKtHrVPI-2024_9_14_11_28.js";
import { a as useWebsetConfig, G as GameTabs$1, b as Guide, D as DanceNum, F as Fresh, S as SearchToolIcon, c as DepositDialog, d as useAsyncEffect, e as useGetState, A as AudioVolumIcon, g as gameTypeNames, I as InfoTabs, T as ToolTabs, f as useSetState, L as LoadingImg, h as LoadMore, i as clipboardExports } from "./App-BLdT6wOK-2024_9_14_11_28.js";
import { u as useActivityNavigate } from "./util-hYNzesA--2024_9_14_11_28.js";
import { M as Maintain } from "./index-DCKgrN6Z-2024_9_14_11_28.js";
import { T as TypeGame } from "./index-CkfsV596-2024_9_14_11_28.js";
import { S as SearchInput } from "./index-CJ4dYH6G-2024_9_14_11_28.js";
import "./s3-BB0I09dN-2024_9_14_11_28.js";
const SvgIcon$2 = (props) => /* @__PURE__ */ reactExports.createElement("svg", { width: 40, height: 30, viewBox: "0 0 40 30", fill: "none", xmlns: "http://www.w3.org/2000/svg", xmlnsXlink: "http://www.w3.org/1999/xlink", ...props }, /* @__PURE__ */ reactExports.createElement("g", { clipPath: "url(#clip0_1_381490)" }, /* @__PURE__ */ reactExports.createElement("rect", { width: 40, height: 30, fill: "url(#pattern0_1_381490)" })), /* @__PURE__ */ reactExports.createElement("defs", null, /* @__PURE__ */ reactExports.createElement("pattern", { id: "pattern0_1_381490", patternContentUnits: "objectBoundingBox", width: 1, height: 1 }, /* @__PURE__ */ reactExports.createElement("use", { xlinkHref: "#image0_1_381490", transform: "matrix(0.01 0 0 0.0133333 0 -0.00666667)" })), /* @__PURE__ */ reactExports.createElement("clipPath", { id: "clip0_1_381490" }, /* @__PURE__ */ reactExports.createElement("rect", { width: 40, height: 30, fill: "white" })), /* @__PURE__ */ reactExports.createElement("image", { id: "image0_1_381490", width: 100, height: 76, xlinkHref: "data:image/png;base64,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" })));
const ActionHotIcon = ({ className } = {}) => {
  return /* @__PURE__ */ jsxRuntimeExports.jsx(SvgIcon$2, { className: joinClass(className) });
};
const SvgIcon$1 = (props) => /* @__PURE__ */ reactExports.createElement("svg", { width: 36, height: 36, viewBox: "0 0 36 36", fill: "none", xmlns: "http://www.w3.org/2000/svg", ...props }, /* @__PURE__ */ reactExports.createElement("g", { id: "Frame 1420070314" }, /* @__PURE__ */ reactExports.createElement("path", { id: "Union", fillRule: "evenodd", clipRule: "evenodd", d: "M26.0815 7.33554C25.3005 6.55449 24.0342 6.55449 23.2531 7.33554C22.4721 8.11659 22.4721 9.38292 23.2531 10.164L29.3392 16.2501H2.03125C0.926681 16.2501 0.03125 17.1455 0.03125 18.2501C0.03125 19.3546 0.926681 20.2501 2.03125 20.2501H28.9414L23.856 25.3355C23.0749 26.1166 23.0749 27.3829 23.856 28.164C24.637 28.945 25.9034 28.945 26.6844 28.164L35.383 19.4654C36.164 18.6844 36.164 17.418 35.383 16.637L26.0815 7.33554ZM2.03125 7.25024C0.926681 7.25024 0.03125 8.14567 0.03125 9.25024C0.03125 10.3548 0.926681 11.2502 2.03125 11.2502H16.1562C17.2608 11.2502 18.1562 10.3548 18.1562 9.25024C18.1562 8.14567 17.2608 7.25024 16.1562 7.25024H2.03125ZM0.03125 27.2502C0.03125 26.1457 0.926681 25.2502 2.03125 25.2502H16.1562C17.2608 25.2502 18.1562 26.1457 18.1562 27.2502C18.1562 28.3548 17.2608 29.2502 16.1562 29.2502H2.03125C0.926681 29.2502 0.03125 28.3548 0.03125 27.2502Z", fill: "#A7B7D7" })));
const SiderMenuIcon = ({ className } = {}) => {
  return /* @__PURE__ */ jsxRuntimeExports.jsx(SvgIcon$1, { className: joinClass(css$e.defaultCss, className) });
};
const SvgIcon = (props) => /* @__PURE__ */ reactExports.createElement("svg", { width: 20, height: 20, viewBox: "0 0 20 20", fill: "none", xmlns: "http://www.w3.org/2000/svg", ...props }, /* @__PURE__ */ reactExports.createElement("path", { d: "M4.70711 11.7929C4.07714 12.4229 4.52331 13.5 5.41421 13.5H14.5856C15.4765 13.5 15.9227 12.4229 15.2927 11.7929L10.707 7.2072C10.3165 6.81668 9.68332 6.81668 9.2928 7.2072L4.70711 11.7929Z", fill: "#039685" }));
const TriangleIcon = ({ className } = {}) => {
  return /* @__PURE__ */ jsxRuntimeExports.jsx(SvgIcon, { className: joinClass(css$e.defaultCss, className) });
};
const svg_theme_fill_color$d = "_svg_theme_fill_color_15jvu_3";
const headerBox = "_headerBox_15jvu_55";
const leftBox$3 = "_leftBox_15jvu_181";
const menuIcon = "_menuIcon_15jvu_187";
const left = "_left_15jvu_181";
const right = "_right_15jvu_195";
const logo$1 = "_logo_15jvu_286";
const rightBox$3 = "_rightBox_15jvu_291";
const moneyBox = "_moneyBox_15jvu_296";
const moneyBox2 = "_moneyBox2_15jvu_296";
const currency = "_currency_15jvu_315";
const loginBtn = "_loginBtn_15jvu_382";
const messageBox$1 = "_messageBox_15jvu_540";
const messageIcon$1 = "_messageIcon_15jvu_549";
const num$2 = "_num_15jvu_557";
const despositOutBtnBox = "_despositOutBtnBox_15jvu_572";
const line = "_line_15jvu_668";
const triangLeIconBox = "_triangLeIconBox_15jvu_760";
const show = "_show_15jvu_768";
const menuBox = "_menuBox_15jvu_856";
const dep = "_dep_15jvu_983";
const saq = "_saq_15jvu_984";
const despositBtn = "_despositBtn_15jvu_1111";
const registerBtn = "_registerBtn_15jvu_1217";
const moneyIcon = "_moneyIcon_15jvu_1435";
const moneySpan = "_moneySpan_15jvu_1443";
const loading = "_loading_15jvu_1450";
const customDN = "_customDN_15jvu_1462";
const freshIcon = "_freshIcon_15jvu_1615";
const download$1 = "_download_15jvu_1714";
const closeIcon = "_closeIcon_15jvu_1839";
const downloadIcon = "_downloadIcon_15jvu_1844";
const btnIcon = "_btnIcon_15jvu_1847";
const download2 = "_download2_15jvu_1850";
const title = "_title_15jvu_1853";
const headerBox_search = "_headerBox_search_15jvu_1860";
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
    token,
    openDownload
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
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$d.download2, onClick: () => {
        if (websetConfig.banner_switch == "1" && !standalone) {
          useUserInfoStore.setState({ openDownload: true });
        } else {
          downloadFn();
        }
      }, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          Image,
          {
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
          }, children: /* @__PURE__ */ jsxRuntimeExports.jsx(SearchToolIcon, {}) })
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
    }, 3 * 1500);
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
const svg_theme_fill_color$a = "_svg_theme_fill_color_ygpb9_3";
const noticeBox = "_noticeBox_ygpb9_55";
const voiceIconBox = "_voiceIconBox_ygpb9_67";
const textBox = "_textBox_ygpb9_162";
const marquee = "_marquee_ygpb9_170";
const space = "_space_ygpb9_179";
const name = "_name_ygpb9_188";
const gameName = "_gameName_ygpb9_259";
const winText = "_winText_ygpb9_330";
const money = "_money_ygpb9_404";
const searchBox = "_searchBox_ygpb9_476";
const messageBox = "_messageBox_ygpb9_489";
const messageIcon = "_messageIcon_ygpb9_495";
const num$1 = "_num_ygpb9_524";
const span = "_span_ygpb9_537";
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
  return /* @__PURE__ */ jsxRuntimeExports.jsx(jsxRuntimeExports.Fragment, { children: setp === 0 ? /* @__PURE__ */ jsxRuntimeExports.jsx(Step0, { className }) : setp === 1 ? /* @__PURE__ */ jsxRuntimeExports.jsx(Step1, { className }) : /* @__PURE__ */ jsxRuntimeExports.jsx(AudioVolumIcon, { className }) });
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
    greenGold: "/home/icons/message_greenGold.webp",
    whiteBrownLauren: "/home/icons/message_whiteBrownLauren.webp",
    whiteRedGucci: "/home/icons/message_whiteRedGucci.webp",
    embraerBlue: "/home/icons/message_embraerBlue.webp",
    elsaPink: "/home/icons/message_elsaPink.webp",
    bvlgariBrown: "/home/icons/message_bvlgariBrown.webp"
  };
  reactExports.useEffect(() => {
    getMarqueeByStore();
  }, []);
  const text = marqueelist.map((maq, i) => {
    const arr = maq.split("|");
    const str2 = '<span class="'.concat(css$a.space, '">\n      <span class="').concat(css$a.name, '">').concat(arr[2], '</span>\n      <span class="').concat(css$a.gameName, '">').concat(arr[1], '</span>\n      <span class="').concat(css$a.winText, '">').concat(trans("它赢了"), '</span>\n      <span class="').concat(css$a.money, '">').concat(getMoneyUnit(true), " ").concat(customToFixed(arr[3]), "</span>&nbsp;\n    </span>");
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
const svg_theme_fill_color$9 = "_svg_theme_fill_color_1pby2_3";
const gameTabsBox = "_gameTabsBox_1pby2_55";
const leftArrowBox = "_leftArrowBox_1pby2_191";
const rightArrowBox = "_rightArrowBox_1pby2_192";
const hiden = "_hiden_1pby2_485";
const gameTabs = "_gameTabs_1pby2_55";
const container = "_container_1pby2_680";
const leftLine = "_leftLine_1pby2_686";
const tabItemBox = "_tabItemBox_1pby2_691";
const select = "_select_1pby2_865";
const icon$3 = "_icon_1pby2_1058";
const iconSelect = "_iconSelect_1pby2_1062";
const icons = "_icons_1pby2_1074";
const small = "_small_1pby2_1305";
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
const SvgArrowIcon = (props) => /* @__PURE__ */ reactExports.createElement("svg", { width: 36, height: 36, viewBox: "0 0 36 36", fill: "none", xmlns: "http://www.w3.org/2000/svg", ...props }, /* @__PURE__ */ reactExports.createElement("g", { clipPath: "url(#clip0_257_191916)" }, /* @__PURE__ */ reactExports.createElement("rect", { width: 36, height: 36, rx: 18, fill: "#161D29" }), /* @__PURE__ */ reactExports.createElement("rect", { x: 0.5625, y: 0.5625, width: 34.875, height: 34.875, rx: 17.4375, stroke: "white", strokeOpacity: 0.1, strokeWidth: 1.125 }), /* @__PURE__ */ reactExports.createElement("path", { d: "M14.1504 10.125L22.0254 18L14.1504 25.875", stroke: "#2FA33F", strokeWidth: 1.96875, strokeLinecap: "round" })), /* @__PURE__ */ reactExports.createElement("defs", null, /* @__PURE__ */ reactExports.createElement("clipPath", { id: "clip0_257_191916" }, /* @__PURE__ */ reactExports.createElement("rect", { width: 36, height: 36, rx: 9, fill: "white" }))));
const GameTabs = () => {
  const { games, selectType, gameOpenMap, gameSortMap } = useGameStore();
  const { appUrl, theme } = useUserInfoStore();
  const leftLineRef = reactExports.useRef();
  const rightLineRef = reactExports.useRef();
  const [leftLineRefInView] = useInViewport(leftLineRef);
  const [rightLineRefInView] = useInViewport(rightLineRef);
  const scrollDom = reactExports.useRef();
  const navigate = useNavigate();
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
        children: /* @__PURE__ */ jsxRuntimeExports.jsx(SvgArrowIcon, {})
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
        children: /* @__PURE__ */ jsxRuntimeExports.jsx(SvgArrowIcon, {})
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
const svg_theme_fill_color$5 = "_svg_theme_fill_color_18nth_3";
const gameBox$3 = "_gameBox_18nth_55";
const logoBox$3 = "_logoBox_18nth_62";
const laodingBox$3 = "_laodingBox_18nth_72";
const game_list_item_hots$3 = "_game_list_item_hots_18nth_171";
const game_list_item_hots_active$1 = "_game_list_item_hots_active_18nth_191";
const identifier$1 = "_identifier_18nth_1";
const gameBox_s$2 = "_gameBox_s_18nth_219";
const platformText$2 = "_platformText_18nth_234";
const game_recommend$1 = "_game_recommend_18nth_249";
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
const svg_theme_fill_color$4 = "_svg_theme_fill_color_a99ex_3";
const itemBox = "_itemBox_a99ex_55";
const topBarBox = "_topBarBox_a99ex_63";
const leftBox$2 = "_leftBox_a99ex_71";
const icon$2 = "_icon_a99ex_77";
const platformLogo$2 = "_platformLogo_a99ex_89";
const rightBox$2 = "_rightBox_a99ex_136";
const itemsContainer = "_itemsContainer_a99ex_207";
const gameBox$2 = "_gameBox_a99ex_214";
const logoBox$2 = "_logoBox_a99ex_221";
const laodingBox$2 = "_laodingBox_a99ex_232";
const whiteLogo = "_whiteLogo_a99ex_331";
const nameBox = "_nameBox_a99ex_351";
const game_list_item_hots$2 = "_game_list_item_hots_a99ex_402";
const game_list_item_hots_active = "_game_list_item_hots_active_a99ex_422";
const identifier = "_identifier_a99ex_1";
const game_recommend = "_game_recommend_a99ex_429";
const btmLoadMoreBox = "_btmLoadMoreBox_a99ex_457";
const tips = "_tips_a99ex_463";
const loadMoreBtn = "_loadMoreBtn_a99ex_546";
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
        page_size: state.page_size,
        page: page2
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
const svg_theme_fill_color$3 = "_svg_theme_fill_color_1dosx_3";
const homeContainer = "_homeContainer_1dosx_55";
const contentBox = "_contentBox_1dosx_164";
const download = "_download_1dosx_176";
const css$3 = {
  svg_theme_fill_color: svg_theme_fill_color$3,
  homeContainer,
  contentBox,
  download
};
const svg_theme_fill_color$2 = "_svg_theme_fill_color_1qgvj_3";
const borderTop = "_borderTop_1qgvj_55";
const styl5Partner = "_styl5Partner_1qgvj_55";
const styl4Company = "_styl4Company_1qgvj_55";
const styl4Partner = "_styl4Partner_1qgvj_55";
const styl3Partner = "_styl3Partner_1qgvj_55";
const style2Company = "_style2Company_1qgvj_55";
const styl1Partner = "_styl1Partner_1qgvj_55";
const tipsBox = "_tipsBox_1qgvj_122";
const detailTip = "_detailTip_1qgvj_902";
const styl1Tips = "_styl1Tips_1qgvj_997";
const styl1Quick = "_styl1Quick_1qgvj_1001";
const styl1Official = "_styl1Official_1qgvj_1005";
const styl1Company = "_styl1Company_1qgvj_1009";
const style2Tips = "_style2Tips_1qgvj_1017";
const styl2Partner = "_styl2Partner_1qgvj_1029";
const tips3List = "_tips3List_1qgvj_1033";
const styl3Tips = "_styl3Tips_1qgvj_1037";
const styl3Official = "_styl3Official_1qgvj_1041";
const styl3Company = "_styl3Company_1qgvj_1045";
const quick2Item = "_quick2Item_1qgvj_1053";
const quick2Title = "_quick2Title_1qgvj_1222";
const quick2List = "_quick2List_1qgvj_1226";
const quick2ListItem = "_quick2ListItem_1qgvj_1231";
const style4Tips = "_style4Tips_1qgvj_1322";
const styl4Quick = "_styl4Quick_1qgvj_1330";
const styl5Tips = "_styl5Tips_1qgvj_1344";
const styl5Quick = "_styl5Quick_1qgvj_1348";
const styl5Official = "_styl5Official_1qgvj_1353";
const style5Tips = "_style5Tips_1qgvj_1362";
const logoContainer = "_logoContainer_1qgvj_1371";
const logo = "_logo_1qgvj_562";
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
const svg_theme_fill_color$1 = "_svg_theme_fill_color_ago9m_3";
const typeGameBox$1 = "_typeGameBox_ago9m_55";
const headBox$1 = "_headBox_ago9m_55";
const leftBox$1 = "_leftBox_ago9m_65";
const icon$1 = "_icon_ago9m_71";
const platformLogo$1 = "_platformLogo_ago9m_83";
const rightBox$1 = "_rightBox_ago9m_129";
const gameBoxs$1 = "_gameBoxs_ago9m_206";
const gameBox$1 = "_gameBox_ago9m_206";
const logoBox$1 = "_logoBox_ago9m_218";
const laodingBox$1 = "_laodingBox_ago9m_228";
const game_list_item_hots$1 = "_game_list_item_hots_ago9m_327";
const gameBox_s$1 = "_gameBox_s_ago9m_338";
const platformText$1 = "_platformText_ago9m_353";
const empty$1 = "_empty_ago9m_365";
const emptyText$1 = "_emptyText_ago9m_379";
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
    greenGold: "/home/icons/empty_icon_greenGold.webp",
    whiteBrownLauren: "/home/icons/empty_icon_whiteBrown.webp",
    whiteRedGucci: "/home/icons/empty_icon_whiteBrown.webp",
    embraerBlue: "/home/icons/empty_icon_embraerBlue.webp",
    elsaPink: "/home/icons/empty_icon_elsaPink.webp",
    bvlgariBrown: "/home/icons/empty_icon_bvlgariBrown.webp"
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
const svg_theme_fill_color = "_svg_theme_fill_color_im7sw_3";
const typeGameBox = "_typeGameBox_im7sw_55";
const headBox = "_headBox_im7sw_55";
const leftBox = "_leftBox_im7sw_65";
const icon = "_icon_im7sw_71";
const platformLogo = "_platformLogo_im7sw_83";
const lengtText = "_lengtText_im7sw_132";
const rightBox = "_rightBox_im7sw_135";
const gameBoxs = "_gameBoxs_im7sw_210";
const gameBox = "_gameBox_im7sw_210";
const logoBox = "_logoBox_im7sw_222";
const laodingBox = "_laodingBox_im7sw_232";
const game_list_item_hots = "_game_list_item_hots_im7sw_331";
const gameBox_s = "_gameBox_s_im7sw_342";
const platformText = "_platformText_im7sw_357";
const empty = "_empty_im7sw_372";
const emptyText = "_emptyText_im7sw_386";
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
    greenGold: "/home/icons/empty_icon_greenGold.webp",
    whiteBrownLauren: "/home/icons/empty_icon_whiteBrown.webp",
    whiteRedGucci: "/home/icons/empty_icon_whiteBrown.webp",
    embraerBlue: "/home/icons/empty_icon_embraerBlue.webp",
    elsaPink: "/home/icons/empty_icon_elsaPink.webp",
    bvlgariBrown: "/home/icons/empty_icon_bvlgariBrown.webp"
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
