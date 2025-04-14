import { v as useUserInfoStore, E as useGameStore, A as useNavigate, r as reactExports, al as events, N as jsxRuntimeExports, Y as instance, T as trans, S as Image, a9 as Message, H as getMoneyUnit, bh as getPlatLaunch, J as Cache } from "./index-CKtHrVPI-2024_9_14_11_28.js";
import { G as GameTabs, L as LoadingImg, h as LoadMore } from "./App-BLdT6wOK-2024_9_14_11_28.js";
import { M as Maintain } from "./index-DCKgrN6Z-2024_9_14_11_28.js";
const svg_theme_fill_color = "_svg_theme_fill_color_1mc6p_3";
const typeGameBox = "_typeGameBox_1mc6p_55";
const logoBox = "_logoBox_1mc6p_60";
const icon = "_icon_1mc6p_67";
const gameBox = "_gameBox_1mc6p_121";
const gameItemBox = "_gameItemBox_1mc6p_128";
const laodingBox = "_laodingBox_1mc6p_138";
const gameItemBox2 = "_gameItemBox2_1mc6p_244";
const laodingBox2 = "_laodingBox2_1mc6p_254";
const gameName = "_gameName_1mc6p_344";
const all = "_all_1mc6p_364";
const gameBox_s = "_gameBox_s_1mc6p_397";
const box2Content = "_box2Content_1mc6p_414";
const btmLoadMoreBox = "_btmLoadMoreBox_1mc6p_420";
const tips = "_tips_1mc6p_426";
const loadMoreBtn = "_loadMoreBtn_1mc6p_509";
const css = {
  svg_theme_fill_color,
  typeGameBox,
  logoBox,
  icon,
  gameBox,
  gameItemBox,
  laodingBox,
  gameItemBox2,
  laodingBox2,
  gameName,
  all,
  gameBox_s,
  box2Content,
  btmLoadMoreBox,
  tips,
  loadMoreBtn
};
const childrenType = ["电子", "捕鱼", "棋牌", "小游戏"];
const TypeGame = (props = {}) => {
  var _a;
  const { token, info } = useUserInfoStore();
  const { renderType } = useGameStore();
  const navigate = useNavigate();
  const [showAll, setShowAll] = reactExports.useState(false);
  const item = props.item || null;
  if (!item)
    return;
  const tabItem = GameTabs.find((tabItem2) => {
    return tabItem2.type && tabItem2.type === item.name;
  }) || null;
  if (!tabItem)
    return;
  const showBy = JSON.parse(item.show_by || "{}");
  const len = renderType === "rect" ? showBy.sh || 10 : showBy.fh || 10;
  const staticRow = renderType === "rect" ? 3 : 4;
  const list = showAll ? item.l || [] : (item.l || []).slice(0, len * staticRow);
  const getPlatLaunchFun = async (id, min_admission) => {
    if (!token) {
      useUserInfoStore.setState({ openForLogin: true });
      return;
    }
    if (info && +info.balance < (+min_admission || 0)) {
      Message.error(instance.t("您的余额低于「最低准入金额」，请存款后才能玩", { amount: min_admission, coin: getMoneyUnit(true) }));
      return;
    }
    const [res, error] = await getPlatLaunch({ id }, { useLoading: true });
    if (res) {
      Cache.set("gameStart", res);
      navigate("/gameStart");
    }
  };
  const IconsCom = tabItem.ActiveIcon || null;
  const toPlatformGame = (pid) => {
    const _item = GameTabs.find((el) => el.type === item.name);
    _item.text;
    const type = _item.type;
    console.log("item", item);
    if (childrenType.includes(type)) {
      navigate("/venuegame?id=".concat(item.id, "&pid=").concat(pid || "0"));
    } else {
      navigate("/venuelist?id=".concat(item.id, "&pid=").concat(pid || "0"));
    }
  };
  const limitClicks = () => {
    setShowAll(true);
  };
  reactExports.useEffect(() => {
    events.on("search", (searchTab) => {
      if (searchTab.type === item.name) {
        navigate("/venuegame?id=".concat(item.id));
      }
    });
    return () => {
      events.off("search");
    };
  }, []);
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", {
    className: css.typeGameBox,
    id: tabItem.text,
    // 如果是venuelist渲染的此组件，不显示顶部内容
    children: [
      props.isVenueListRender ? null : /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.logoBox, children: [
        IconsCom ? /* @__PURE__ */ jsxRuntimeExports.jsx(IconsCom, { isSelect: true, className: css.icon }) : null,
        /* @__PURE__ */ jsxRuntimeExports.jsx("span", { children: instance.t(tabItem.text) }),
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.all, onClick: () => toPlatformGame(), children: [
          trans("Tudo"),
          " ",
          (_a = item.l) == null ? void 0 : _a.length
        ] })
      ] }),
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.gameBox, children: list.map((game, idx) => {
        let gameImg = game.promo_image || game.popular_image || game.img;
        if (renderType === "rect") {
          gameImg = game.img.replace("images-br", "images-br-rect");
        }
        return (
          // 根据renderType判断显示正方形还是长方形
          renderType === "rect" ? /* @__PURE__ */ jsxRuntimeExports.jsxs(
            "div",
            {
              img: gameImg,
              className: css.gameItemBox,
              onClick: () => {
                if (game.maintained === 2)
                  return;
                if (childrenType.includes(item.name)) {
                  toPlatformGame(game.id);
                  return;
                }
                getPlatLaunchFun(game.id, game.min_admission);
              },
              children: [
                /* @__PURE__ */ jsxRuntimeExports.jsx(
                  Image,
                  {
                    loading: /* @__PURE__ */ jsxRuntimeExports.jsx(LoadingImg, { className: css.laodingBox }),
                    src: gameImg,
                    remote: true,
                    isGame: true
                  }
                ),
                game.maintained === 2 ? /* @__PURE__ */ jsxRuntimeExports.jsx(Maintain, {}) : null,
                /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.gameBox_s, children: [
                  " ",
                  game.name,
                  " "
                ] })
              ]
            },
            idx
          ) : /* @__PURE__ */ jsxRuntimeExports.jsxs(
            "div",
            {
              img: gameImg,
              className: css.gameItemBox2,
              onClick: () => {
                if (game.maintained === 2)
                  return;
                if (childrenType.includes(item.name)) {
                  toPlatformGame(game.id);
                  return;
                }
                getPlatLaunchFun(game.id, game.min_admission);
              },
              children: [
                /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.box2Content, children: [
                  /* @__PURE__ */ jsxRuntimeExports.jsx(
                    Image,
                    {
                      loading: /* @__PURE__ */ jsxRuntimeExports.jsx(LoadingImg, { className: css.laodingBox2 }),
                      remote: true,
                      isGame: true,
                      src: gameImg
                    }
                  ),
                  game.maintained === 2 ? /* @__PURE__ */ jsxRuntimeExports.jsx(Maintain, {}) : null
                ] }),
                /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.gameName, children: game.name })
              ]
            },
            idx
          )
        );
      }) }),
      list.length === (item.l || []).length ? null : /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.btmLoadMoreBox, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: css.tips, children: instance.t("显示{{total}}款老虎机游戏中的{{num}}款游戏", {
          total: (item.l || []).length || 0,
          num: list.length || 0
        }) }),
        (item.l || []).length > list.length ? /* @__PURE__ */ jsxRuntimeExports.jsx(
          LoadMore,
          {
            className: css.loadMoreBtn,
            onClick: () => {
              limitClicks();
            }
          }
        ) : null
      ] })
    ]
  });
};
export {
  TypeGame as T
};
