import { o as useLatest, r as reactExports, _ as __spreadArray, b as __read, d as useUnmount, k as __awaiter, l as __generator, q as getTargetElement, c as __assign, N as jsxRuntimeExports, Q as joinClass, V as css$2, v as useUserInfoStore, a9 as Message, Y as instance, H as getMoneyUnit, S as Image, bj as favoritesremove, bk as favorites, be as useInViewport, A as useNavigate, E as useGameStore, bW as getSlotSearch, bh as getPlatLaunch, J as Cache, bi as historySave, t as getQueryVariable } from "./index-CKtHrVPI-2024_9_14_11_28.js";
import { Z as debounce, _ as useRequest, $ as useMemoizedFn, a0 as useEventListener, a1 as useUpdateEffect, L as LoadingImg, h as LoadMore, a2 as BlockchainIcon, a3 as CartasIcon, a4 as SlotsIcon, a5 as ActiveSlots, a6 as PescariaIcon, Q as InnerPageWithBackContext, G as GameTabs } from "./App-BLdT6wOK-2024_9_14_11_28.js";
import { S as SearchInput } from "./index-CJ4dYH6G-2024_9_14_11_28.js";
import { M as Maintain } from "./index-DCKgrN6Z-2024_9_14_11_28.js";
function isNodeOrWeb() {
  var freeGlobal = (typeof global === "undefined" ? "undefined" : typeof global) == "object" && global && global.Object === Object && global;
  var freeSelf = typeof self == "object" && self && self.Object === Object && self;
  return freeGlobal || freeSelf;
}
if (!isNodeOrWeb()) {
  global.Date = Date;
}
function useDebounceFn(fn, options) {
  var _a;
  var fnRef = useLatest(fn);
  var wait = (_a = options === null || options === void 0 ? void 0 : options.wait) !== null && _a !== void 0 ? _a : 1e3;
  var debounced = reactExports.useMemo(function() {
    return debounce(function() {
      var args = [];
      for (var _i = 0; _i < arguments.length; _i++) {
        args[_i] = arguments[_i];
      }
      return fnRef.current.apply(fnRef, __spreadArray([], __read(args), false));
    }, wait, options);
  }, []);
  useUnmount(function() {
    debounced.cancel();
  });
  return {
    run: debounced,
    cancel: debounced.cancel,
    flush: debounced.flush
  };
}
var getScrollTop = function(el) {
  if (el === document || el === document.documentElement || el === document.body) {
    return Math.max(window.pageYOffset, document.documentElement.scrollTop, document.body.scrollTop);
  }
  return el.scrollTop;
};
var getScrollHeight = function(el) {
  return el.scrollHeight || Math.max(document.documentElement.scrollHeight, document.body.scrollHeight);
};
var getClientHeight = function(el) {
  return el.clientHeight || Math.max(document.documentElement.clientHeight, document.body.clientHeight);
};
var useInfiniteScroll = function(service, options) {
  if (options === void 0) {
    options = {};
  }
  var target = options.target, isNoMore = options.isNoMore, _a = options.threshold, threshold = _a === void 0 ? 100 : _a, _b = options.reloadDeps, reloadDeps = _b === void 0 ? [] : _b, manual = options.manual, onBefore = options.onBefore, onSuccess = options.onSuccess, onError = options.onError, onFinally = options.onFinally;
  var _c = __read(reactExports.useState(), 2), finalData = _c[0], setFinalData = _c[1];
  var _d = __read(reactExports.useState(false), 2), loadingMore = _d[0], setLoadingMore = _d[1];
  var noMore = reactExports.useMemo(function() {
    if (!isNoMore)
      return false;
    return isNoMore(finalData);
  }, [finalData]);
  var _e = useRequest(function(lastData) {
    return __awaiter(void 0, void 0, void 0, function() {
      var currentData;
      var _a2, _b2;
      return __generator(this, function(_c2) {
        switch (_c2.label) {
          case 0:
            return [4, service(lastData)];
          case 1:
            currentData = _c2.sent();
            if (!lastData) {
              setFinalData(__assign(__assign({}, currentData), {
                list: __spreadArray([], __read((_a2 = currentData.list) !== null && _a2 !== void 0 ? _a2 : []), false)
              }));
            } else {
              setFinalData(__assign(__assign({}, currentData), {
                list: __spreadArray(__spreadArray([], __read((_b2 = lastData.list) !== null && _b2 !== void 0 ? _b2 : []), false), __read(currentData.list), false)
              }));
            }
            return [2, currentData];
        }
      });
    });
  }, {
    manual,
    onFinally: function(_, d, e) {
      setLoadingMore(false);
      onFinally === null || onFinally === void 0 ? void 0 : onFinally(d, e);
    },
    onBefore: function() {
      return onBefore === null || onBefore === void 0 ? void 0 : onBefore();
    },
    onSuccess: function(d) {
      setTimeout(function() {
        scrollMethod();
      });
      onSuccess === null || onSuccess === void 0 ? void 0 : onSuccess(d);
    },
    onError: function(e) {
      return onError === null || onError === void 0 ? void 0 : onError(e);
    }
  }), loading = _e.loading, error = _e.error, run = _e.run, runAsync = _e.runAsync, cancel = _e.cancel;
  var loadMore = useMemoizedFn(function() {
    if (noMore)
      return;
    setLoadingMore(true);
    run(finalData);
  });
  var loadMoreAsync = useMemoizedFn(function() {
    if (noMore)
      return Promise.reject();
    setLoadingMore(true);
    return runAsync(finalData);
  });
  var reload = function() {
    setLoadingMore(false);
    return run();
  };
  var reloadAsync = function() {
    setLoadingMore(false);
    return runAsync();
  };
  var scrollMethod = function() {
    var el = getTargetElement(target);
    if (!el) {
      return;
    }
    el = el === document ? document.documentElement : el;
    var scrollTop = getScrollTop(el);
    var scrollHeight = getScrollHeight(el);
    var clientHeight = getClientHeight(el);
    if (scrollHeight - scrollTop <= clientHeight + threshold) {
      loadMore();
    }
  };
  useEventListener("scroll", function() {
    if (loading || loadingMore) {
      return;
    }
    scrollMethod();
  }, {
    target
  });
  useUpdateEffect(function() {
    run();
  }, __spreadArray([], __read(reloadDeps), false));
  return {
    data: finalData,
    loading: !loadingMore && loading,
    error,
    loadingMore,
    noMore,
    loadMore,
    loadMoreAsync,
    reload: useMemoizedFn(reload),
    reloadAsync: useMemoizedFn(reloadAsync),
    mutate: setFinalData,
    cancel
  };
};
const SvgBlockchaim1 = (props) => /* @__PURE__ */ reactExports.createElement("svg", { width: 40, height: 30, viewBox: "0 0 40 30", fill: "none", xmlns: "http://www.w3.org/2000/svg", xmlnsXlink: "http://www.w3.org/1999/xlink", ...props }, /* @__PURE__ */ reactExports.createElement("g", { clipPath: "url(#clip0_1_381711)" }, /* @__PURE__ */ reactExports.createElement("rect", { width: 40, height: 30, fill: "url(#pattern0_1_381711)" })), /* @__PURE__ */ reactExports.createElement("defs", null, /* @__PURE__ */ reactExports.createElement("pattern", { id: "pattern0_1_381711", patternContentUnits: "objectBoundingBox", width: 1, height: 1 }, /* @__PURE__ */ reactExports.createElement("use", { xlinkHref: "#image0_1_381711", transform: "matrix(0.01 0 0 0.0133333 0 -0.00666667)" })), /* @__PURE__ */ reactExports.createElement("clipPath", { id: "clip0_1_381711" }, /* @__PURE__ */ reactExports.createElement("rect", { width: 40, height: 30, fill: "white" })), /* @__PURE__ */ reactExports.createElement("image", { id: "image0_1_381711", width: 100, height: 76, xlinkHref: "data:image/png;base64,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" })));
const ActionBlockchaim = ({ className } = {}) => {
  return /* @__PURE__ */ jsxRuntimeExports.jsx(SvgBlockchaim1, { className: joinClass(className) });
};
const SvgIcon$2 = (props) => /* @__PURE__ */ reactExports.createElement("svg", { width: 40, height: 30, viewBox: "0 0 40 30", fill: "none", xmlns: "http://www.w3.org/2000/svg", xmlnsXlink: "http://www.w3.org/1999/xlink", ...props }, /* @__PURE__ */ reactExports.createElement("g", { clipPath: "url(#clip0_1_381707)" }, /* @__PURE__ */ reactExports.createElement("rect", { width: 40, height: 30, fill: "url(#pattern0_1_381707)" })), /* @__PURE__ */ reactExports.createElement("defs", null, /* @__PURE__ */ reactExports.createElement("pattern", { id: "pattern0_1_381707", patternContentUnits: "objectBoundingBox", width: 1, height: 1 }, /* @__PURE__ */ reactExports.createElement("use", { xlinkHref: "#image0_1_381707", transform: "matrix(0.01 0 0 0.0133333 0 -0.00666667)" })), /* @__PURE__ */ reactExports.createElement("clipPath", { id: "clip0_1_381707" }, /* @__PURE__ */ reactExports.createElement("rect", { width: 40, height: 30, fill: "white" })), /* @__PURE__ */ reactExports.createElement("image", { id: "image0_1_381707", width: 100, height: 76, xlinkHref: "data:image/png;base64,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" })));
const ActionFishing = ({ className } = {}) => {
  return /* @__PURE__ */ jsxRuntimeExports.jsx(SvgIcon$2, { className: joinClass(className) });
};
const SvgIcon$1 = (props) => /* @__PURE__ */ reactExports.createElement("svg", { width: 40, height: 30, viewBox: "0 0 40 30", fill: "none", xmlns: "http://www.w3.org/2000/svg", xmlnsXlink: "http://www.w3.org/1999/xlink", ...props }, /* @__PURE__ */ reactExports.createElement("g", { clipPath: "url(#clip0_1_381679)" }, /* @__PURE__ */ reactExports.createElement("rect", { width: 40, height: 30, fill: "url(#pattern0_1_381679)" })), /* @__PURE__ */ reactExports.createElement("defs", null, /* @__PURE__ */ reactExports.createElement("pattern", { id: "pattern0_1_381679", patternContentUnits: "objectBoundingBox", width: 1, height: 1 }, /* @__PURE__ */ reactExports.createElement("use", { xlinkHref: "#image0_1_381679", transform: "matrix(0.01 0 0 0.0133333 0 -0.00666667)" })), /* @__PURE__ */ reactExports.createElement("clipPath", { id: "clip0_1_381679" }, /* @__PURE__ */ reactExports.createElement("rect", { width: 40, height: 30, fill: "white" })), /* @__PURE__ */ reactExports.createElement("image", { id: "image0_1_381679", width: 100, height: 76, xlinkHref: "data:image/png;base64,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" })));
const ActionPoker = ({ className } = {}) => {
  return /* @__PURE__ */ jsxRuntimeExports.jsx(SvgIcon$1, { className: joinClass(className) });
};
const SvgIcon = (props) => /* @__PURE__ */ reactExports.createElement("svg", { width: 40, height: 30, viewBox: "0 0 40 30", fill: "none", xmlns: "http://www.w3.org/2000/svg", ...props }, /* @__PURE__ */ reactExports.createElement("path", { d: "M7 5C7 3.34315 8.34315 2 10 2H16C17.6569 2 19 3.34315 19 5V14H10C8.34315 14 7 12.6569 7 11V5Z", fill: "#4FCABC" }), /* @__PURE__ */ reactExports.createElement("path", { d: "M21 5C21 3.34315 22.3431 2 24 2H30C31.6569 2 33 3.34315 33 5V11C33 12.6569 31.6569 14 30 14H21V5Z", fill: "#4FCABC" }), /* @__PURE__ */ reactExports.createElement("path", { d: "M7 19C7 17.3431 8.34315 16 10 16H19V25C19 26.6569 17.6569 28 16 28H10C8.34315 28 7 26.6569 7 25V19Z", fill: "#4FCABC" }), /* @__PURE__ */ reactExports.createElement("path", { d: "M21 16H30C31.6569 16 33 17.3431 33 19V25C33 26.6569 31.6569 28 30 28H24C22.3431 28 21 26.6569 21 25V16Z", fill: "#4FCABC" }));
const TudoIcon = ({ className } = {}) => {
  return /* @__PURE__ */ jsxRuntimeExports.jsx(SvgIcon, { className: joinClass(css$2.defaultCss, className) });
};
const svg_theme_fill_color$1 = "_svg_theme_fill_color_13vhy_3";
const subclass = "_subclass_13vhy_55";
const siderbar = "_siderbar_13vhy_170";
const subMenu = "_subMenu_13vhy_485";
const game_list_scroll = "_game_list_scroll_13vhy_856";
const game_recommend$1 = "_game_recommend_13vhy_1172";
const identifier$1 = "_identifier_13vhy_1";
const css$1 = {
  svg_theme_fill_color: svg_theme_fill_color$1,
  subclass,
  siderbar,
  subMenu,
  game_list_scroll,
  game_recommend: game_recommend$1,
  identifier: identifier$1
};
const svg_theme_fill_color = "_svg_theme_fill_color_1v8j8_3";
const game_list_item = "_game_list_item_1v8j8_55";
const game_recommend = "_game_recommend_1v8j8_286";
const identifier = "_identifier_1v8j8_1";
const css = {
  svg_theme_fill_color,
  game_list_item,
  game_recommend,
  identifier
};
const RectGameItem = ({ item, gameNamesMap, maintainedMap, getPlatLaunchFun, delFavorites = (id) => {
}, FavoritosType = true }) => {
  const gameImg = item.img.replace("images-br/", "images-br-rect/");
  const [isShow, setIsShow] = reactExports.useState(false);
  const [isEnlarged, setIsEnlarged] = reactExports.useState(false);
  reactExports.useEffect(() => {
    if (item.is_favorites) {
      setIsShow(true);
    } else {
      setIsShow(false);
    }
  }, [item]);
  const { token, info } = useUserInfoStore();
  const btnCollect = async (game) => {
    if (!token) {
      useUserInfoStore.setState({ openForLogin: true });
      return;
    }
    if (isShow) {
      const [res, err] = await favoritesremove({ pid: game.platform_id, code: game.game_id });
      if (res) {
        if (FavoritosType) {
          setIsShow(false);
        }
        setIsEnlarged(false);
        delFavorites(game.game_id);
      }
    } else {
      const [res, err] = await favorites({ pid: game.platform_id, code: game.game_id });
      if (res)
        setIsShow(true);
      setIsEnlarged(true);
    }
  };
  return /* @__PURE__ */ jsxRuntimeExports.jsx(
    "div",
    {
      className: joinClass(css.game_list_item, "button"),
      onClick: () => {
        if (maintainedMap[item.platform_id] === 2 || item.maintained === 2)
          return;
        if (info && +info.balance < (+item.min_admission || 0)) {
          Message.error(instance.t("您的余额低于「最低准入金额」，请存款后才能玩", { amount: item.min_admission, coin: getMoneyUnit(true) }));
          return;
        }
        getPlatLaunchFun(item.platform_id, item.game_id);
      },
      children: /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: "game_img_box", children: [
        item.is_recommend === 1 && /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { className: css.game_recommend, src: "/home/icons/recommend.webp" }),
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { onClick: (e) => {
          e.stopPropagation();
          btnCollect(item);
        }, className: joinClass("game_list_item_hots", isEnlarged ? "game_list_item_hots_active" : ""), children: isShow && /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { src: "/home/icons/collect_active2.webp" }) }),
        /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { loading: /* @__PURE__ */ jsxRuntimeExports.jsx(LoadingImg, { className: "laodingBox" }), src: gameImg, remote: true, isGame: true }),
        maintainedMap[item.platform_id] === 2 || item.maintained === 2 ? /* @__PURE__ */ jsxRuntimeExports.jsx(Maintain, { className: "maintain" }) : null,
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "gameBox_s", children: item.en_name })
      ] })
    }
  );
};
const getTypeName = (type) => {
  switch (type) {
    case 2:
      return {
        name: "Pescaria",
        IconsCom: PescariaIcon,
        logo: "fishing_active.webp",
        ActiveIcon: ActionFishing
      };
    case 3:
      return {
        name: "Slots",
        IconsCom: SlotsIcon,
        logo: "slots_active.webp",
        ActiveIcon: ActiveSlots
      };
    case 5:
      return {
        name: "Cartas",
        IconsCom: CartasIcon,
        logo: "cartas_active.webp",
        ActiveIcon: ActionPoker
      };
    case 9:
      return {
        name: "Blockchain",
        IconsCom: BlockchainIcon,
        logo: "blockchain_active.webp",
        ActiveIcon: ActionBlockchaim
      };
    default:
      return {};
  }
};
const SiderBar = ({ onChange, value, list }) => {
  const { gameNamesMap } = useGameStore();
  const changeSiderBar = (bar) => {
    onChange(bar);
  };
  const siderList = reactExports.useMemo(() => {
    var _a;
    const type = (_a = list[0]) == null ? void 0 : _a.game_type;
    const logoItem = {
      id: "0",
      //pid 等于 0 查询所有该类型场馆下的游戏
      game_type: type,
      ...getTypeName(type)
    };
    return [logoItem, ...list];
  }, [list]);
  return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$1.siderbar, children: siderList.map((item, index) => {
    const IconsCom = item.IconsCom || /* @__PURE__ */ jsxRuntimeExports.jsx(jsxRuntimeExports.Fragment, {});
    const ActiveIcon = item.ActiveIcon || /* @__PURE__ */ jsxRuntimeExports.jsx(jsxRuntimeExports.Fragment, {});
    const isSelect = value === item.id;
    return /* @__PURE__ */ jsxRuntimeExports.jsxs(
      "div",
      {
        className: "siderbar-item button ".concat(value === item.id && "siderbar-item-active"),
        onClick: (e) => {
          changeSiderBar(item);
        },
        // 如果是首个siderbar 则查询所有场馆游戏且使用场馆类型icon
        children: [
          !index ? isSelect ? /* @__PURE__ */ jsxRuntimeExports.jsx(ActiveIcon, { className: "logo" }) : /* @__PURE__ */ jsxRuntimeExports.jsx(IconsCom, { isSelect, className: "logo" }) : /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { src: "/game/logo/".concat(gameNamesMap[item.id], ".webp") }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: instance.t(item.name) })
        ]
      },
      index
    );
  }) });
};
const SubMenu = ({ options, value, onClick }) => {
  useUserInfoStore();
  return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$1.subMenu, children: options.map((item) => {
    item.IconsCom || "";
    item.value === value;
    return /* @__PURE__ */ jsxRuntimeExports.jsx(
      "div",
      {
        className: "button ".concat(item.value === value ? "active" : ""),
        onClick: () => {
          onClick(item);
        },
        children: /* @__PURE__ */ jsxRuntimeExports.jsx("span", { children: instance.t(item.label) })
      },
      item.value
    );
  }) });
};
const PAGE_SIZE = 51;
const subOptions = [
  {
    icon: "/home/icons/all_active.webp",
    blue: "/home/icons/all_active_blue.webp",
    IconsCom: TudoIcon,
    value: 0,
    label: "Tudo"
  },
  // {
  //   icon: `/home/icons/hot_active.webp`,
  //   blue: `/home/icons/hot_blue_active.webp`,
  //   IconsCom: HotIcon,
  //   value: 2,
  //   label: 'Popular'
  // },
  {
    value: 3,
    label: "Recente"
  },
  {
    value: 4,
    label: "Favoritos"
  }
];
const SearchGame = ({ platType, paramPid }) => {
  const { token } = useUserInfoStore();
  const moreRef = reactExports.useRef(null);
  const [inViewport] = useInViewport(moreRef);
  const navigate = useNavigate();
  const [siderList, setSiderList] = reactExports.useState([]);
  const initState = {
    pid: paramPid || "0",
    flag: 0,
    keyword: ""
  };
  const {
    games,
    gameNamesMap,
    maintainedMap,
    renderType,
    selectGame: listState
  } = useGameStore();
  const updateListState = (game) => {
    useGameStore.setState({
      selectGame: game
    });
  };
  reactExports.useEffect(() => {
    const g = siderList.find((item) => item.id == listState.pid);
    console.log("g :", g);
    console.log("listState.pid :", listState.pid);
    if (!g) {
      updateListState({ ...initState });
    }
  }, [siderList]);
  reactExports.useEffect(() => {
    return () => {
      updateListState({
        ...initState,
        pid: "-1"
      });
    };
  }, []);
  reactExports.useEffect(() => {
    var _a;
    if (games.length === 0)
      return;
    const list2 = ((_a = games.find((item) => item.id === +platType)) == null ? void 0 : _a.l) || [];
    list2.map((res, idx) => {
      let name = res.name.split(" ")[0];
      res.name = name;
    });
    setSiderList(list2);
  }, [games, platType]);
  const {
    reload: searchGame,
    data,
    loading,
    loadMore,
    loadingMore
  } = useInfiniteScroll(
    (d) => {
      const page = d ? Math.ceil(d.list.length / PAGE_SIZE) + 1 : 1;
      if (listState.pid) {
        return getGameList({
          ...listState,
          page_size: PAGE_SIZE,
          page,
          game_type: platType
        });
      }
    },
    { reloadDeps: [listState.pid, listState.flag, platType], manual: true }
  );
  const [list, setList] = reactExports.useState([]);
  reactExports.useEffect(() => {
    setList((data == null ? void 0 : data.list) || []);
  }, [data]);
  const hasMore = data && data.list.length < data.total;
  const { run: getGameList } = useDebounceFn(
    async (params) => {
      const [result] = await getSlotSearch(params, { useLoading: true });
      return {
        list: result.d,
        total: result.t
      };
    },
    { wait: 300, leading: true }
  );
  const changeMenu = (cur) => {
    if (cur.value !== listState.flag) {
      updateListState({
        ...initState,
        flag: cur.value
      });
    }
  };
  const handleInput = (val) => {
    updateListState({
      ...listState,
      keyword: val
    });
  };
  const handleSearch = () => {
    searchGame();
  };
  const handleKeydown = (e) => {
    if (e.keyCode === 13 || e.key === "Enter") {
      searchGame();
    }
  };
  const handleChangeBar = async (plat) => {
    updateListState({
      ...initState,
      pid: plat.id
    });
  };
  const getPlatLaunchFun = async (id, code = "") => {
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
  reactExports.useEffect(() => {
    if (inViewport && hasMore) {
      loadMore();
    }
  }, [inViewport, hasMore]);
  const { info } = useUserInfoStore();
  const handleDelteFav = (id) => {
    if (listState.flag == 4) {
      const newlist = list.filter((item) => item.game_id !== id);
      setList(newlist);
    }
  };
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
        if (listState.flag == 4) {
          const newlist = list.filter((item) => item.id !== game.id);
          console.log(newlist);
          setList(newlist);
        } else {
          list.map((item, idx) => {
            if (item.id === game.id) {
              list[idx].is_favorites = false;
            }
          });
          updateListState({
            ...listState
          });
        }
      }
    } else {
      const [res, err] = await favorites({
        pid: game.platform_id,
        code: game.game_id
      });
      if (res) {
        list.map((item, idx) => {
          if (item.id === game.id) {
            list[idx].is_favorites = true;
          }
        });
        updateListState({
          ...listState
        });
      }
      setIsEnlarged(true);
    }
  };
  if (!games || games.length === 0 || siderList.length === 0) {
    return null;
  }
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.subclass, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsx(
      SearchInput,
      {
        value: listState.keyword,
        placeholder: instance.t("搜索游戏"),
        onClear: searchGame,
        onInput: handleInput,
        onSearch: handleSearch,
        onKeyDown: handleKeydown
      }
    ),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: "flex_box", style: { position: "relative" }, children: [
      siderList.length !== 0 && /* @__PURE__ */ jsxRuntimeExports.jsx(
        SiderBar,
        {
          onChange: handleChangeBar,
          list: siderList,
          value: listState.pid
        }
      ),
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: "container", children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "form_line", children: /* @__PURE__ */ jsxRuntimeExports.jsx(
          SubMenu,
          {
            options: subOptions,
            value: listState.flag,
            onClick: changeMenu
          }
        ) }),
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.game_list_scroll, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "game_list", children: list.map((item, idx) => {
            let isShow = (item == null ? void 0 : item.is_favorites) || false;
            if (renderType === "rect") {
              return /* @__PURE__ */ jsxRuntimeExports.jsx(
                RectGameItem,
                {
                  item,
                  gameNamesMap,
                  delFavorites: handleDelteFav,
                  FavoritosType: listState.flag == 4 ? false : true,
                  maintainedMap,
                  getPlatLaunchFun
                },
                idx
              );
            }
            return /* @__PURE__ */ jsxRuntimeExports.jsxs(
              "div",
              {
                className: "game_list_item button",
                onClick: () => {
                  if (maintainedMap[item.platform_id] === 2 || item.maintained === 2)
                    return;
                  if (info && +info.balance < (+item.min_admission || 0)) {
                    Message.error(instance.t("您的余额低于「最低准入金额」，请存款后才能玩", { amount: item.min_admission, coin: getMoneyUnit(true) }));
                    return;
                  }
                  getPlatLaunchFun(item.platform_id, item.game_id);
                },
                children: [
                  /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: "game_img_box", children: [
                    item.is_recommend === 1 && /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { className: css$1.game_recommend, src: "/home/icons/recommend.webp" }),
                    /* @__PURE__ */ jsxRuntimeExports.jsx(
                      "div",
                      {
                        onClick: (e) => {
                          e.stopPropagation();
                          btnCollect(item);
                        },
                        className: joinClass(
                          "game_list_item_hots",
                          isEnlarged ? "game_list_item_hots_active" : ""
                        ),
                        children: isShow && /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { src: "/home/icons/collect_active2.webp" })
                      }
                    ),
                    /* @__PURE__ */ jsxRuntimeExports.jsx(
                      Image,
                      {
                        loading: /* @__PURE__ */ jsxRuntimeExports.jsx(LoadingImg, { className: "laodingBox" }),
                        src: item.img,
                        remote: true,
                        isGame: true
                      }
                    ),
                    maintainedMap[item.platform_id] === 2 || item.maintained === 2 ? /* @__PURE__ */ jsxRuntimeExports.jsx(Maintain, {}) : null
                  ] }),
                  /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "game_list_item_name", children: item.en_name })
                ]
              },
              idx
            );
          }) }),
          /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: "load_more", children: [
            /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: instance.t("显示{{total}}款老虎机游戏中的{{num}}款游戏", {
              total: (data == null ? void 0 : data.total) || 0,
              num: (data == null ? void 0 : data.list.length) || 0
            }) }),
            hasMore && /* @__PURE__ */ jsxRuntimeExports.jsx(
              LoadMore,
              {
                ref: moreRef,
                onClick: loadMore,
                disabled: loadingMore,
                className: "load_btn"
              }
            )
          ] })
        ] })
      ] })
    ] })
  ] });
};
const PlatformList = (props) => {
  const { games } = useGameStore();
  const { setTitle } = reactExports.useContext(InnerPageWithBackContext);
  const id = getQueryVariable("id");
  const pid = getQueryVariable("pid");
  const [item, setItem] = reactExports.useState(null);
  reactExports.useEffect(() => {
    if (games && item) {
      setTimeout(() => {
        var _a;
        const title = (_a = GameTabs.find((_item) => _item.type === item.name)) == null ? void 0 : _a.text;
        setTitle(title);
      }, 300);
    }
  }, [games, item]);
  const gameItem = games.find((item2) => "".concat(item2.id) === "".concat(id));
  if (!gameItem) {
    return null;
  } else {
    if (!item) {
      setItem(gameItem);
    }
  }
  if (!games || games.length === 0) {
    return null;
  }
  return /* @__PURE__ */ jsxRuntimeExports.jsx(jsxRuntimeExports.Fragment, { children: /* @__PURE__ */ jsxRuntimeExports.jsx("div", { style: {
    display: "flex",
    flexDirection: "column",
    fontSize: "14rem"
  }, children: item ? /* @__PURE__ */ jsxRuntimeExports.jsx(SearchGame, { paramPid: pid, platType: id }, pid) : null }) });
};
export {
  PlatformList as default
};
