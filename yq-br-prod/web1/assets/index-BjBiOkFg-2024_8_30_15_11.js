
import { m as useLatest, r as reactExports, _ as __spreadArray, b as __read, u as useUnmount, h as __awaiter, j as __generator, n as getTargetElement, c as __assign, q as useUserInfoStore, K as jsxRuntimeExports, P as joinClass, a7 as Message, a9 as instance, E as getMoneyUnit, R as Image, bh as favoritesremove, bi as favorites, bc as useInViewport, x as useNavigate, B as useGameStore, bQ as getSlotSearch, bf as getPlatLaunch, G as Cache, bg as historySave, p as getQueryVariable } from "./index-a_Ow1xUN-2024_8_30_15_11.js";
import { ar as debounce, as as useRequest, at as useMemoizedFn, au as useEventListener, av as useUpdateEffect, L as LoadingImg, i as LoadMore, aw as BlockchainIcon, ax as CartasIcon, ay as SlotsIcon, az as ActiveSlots, aA as PescariaIcon, ak as InnerPageWithBackContext, G as GameTabs } from "./App-D9NLPZJN-2024_8_30_15_11.js";
import { S as SearchInput } from "./index-Bhw2MjsX-2024_8_30_15_11.js";
import { M as Maintain } from "./index-Cw8D1bq7-2024_8_30_15_11.js";
import { TudoIcon } from "./Tudo-DV5ETPvZ-2024_8_30_15_11.js";
import { ActionBlockchaim } from "./ActionBlockchaim-NFa5p7TG-2024_8_30_15_11.js";
import { ActionFishing } from "./ActionFishing-C12EC6Lr-2024_8_30_15_11.js";
import { ActionPoker } from "./ActionPoker-CLq5mRy_-2024_8_30_15_11.js";
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
const svg_theme_fill_color$1 = "_svg_theme_fill_color_szzc3_3";
const subclass = "_subclass_szzc3_55";
const siderbar = "_siderbar_szzc3_155";
const subMenu = "_subMenu_szzc3_409";
const game_list_scroll = "_game_list_scroll_szzc3_710";
const game_recommend$1 = "_game_recommend_szzc3_990";
const identifier$1 = "_identifier_szzc3_1";
const css$1 = {
  svg_theme_fill_color: svg_theme_fill_color$1,
  subclass,
  siderbar,
  subMenu,
  game_list_scroll,
  game_recommend: game_recommend$1,
  identifier: identifier$1
};
const svg_theme_fill_color = "_svg_theme_fill_color_5ersv_3";
const game_list_item = "_game_list_item_5ersv_55";
const game_recommend = "_game_recommend_5ersv_268";
const identifier = "_identifier_5ersv_1";
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
          Message.error(instance.t("æ‚¨çš„ä½™é¢ä½ŽäºŽã€Œæœ€ä½Žå‡†å…¥é‡‘é¢ã€ï¼Œè¯·å­˜æ¬¾åŽæ‰èƒ½çŽ©", { amount: item.min_admission, coin: getMoneyUnit(true) }));
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
      //pid ç­‰äºŽ 0 æŸ¥è¯¢æ‰€æœ‰è¯¥ç±»åž‹åœºé¦†ä¸‹çš„æ¸¸æˆ
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
        // å¦‚æžœæ˜¯é¦–ä¸ªsiderbar åˆ™æŸ¥è¯¢æ‰€æœ‰åœºé¦†æ¸¸æˆä¸”ä½¿ç”¨åœºé¦†ç±»åž‹icon
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
        placeholder: instance.t("æœç´¢æ¸¸æˆ"),
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
                    Message.error(instance.t("æ‚¨çš„ä½™é¢ä½ŽäºŽã€Œæœ€ä½Žå‡†å…¥é‡‘é¢ã€ï¼Œè¯·å­˜æ¬¾åŽæ‰èƒ½çŽ©", { amount: item.min_admission, coin: getMoneyUnit(true) }));
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
            /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: instance.t("æ˜¾ç¤º{{total}}æ¬¾è€è™Žæœºæ¸¸æˆä¸­çš„{{num}}æ¬¾æ¸¸æˆ", {
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
