import { v as useUserInfoStore, r as reactExports, A as useNavigate, E as useGameStore, aE as getGamesNav, N as jsxRuntimeExports, ab as customToFixed, bG as getRebateConfig } from "./index-CKtHrVPI-2024_9_14_11_28.js";
import { l as useTranslation, x as rebateTypes, M as MoreInMineIcon, j as LeftNav } from "./App-BLdT6wOK-2024_9_14_11_28.js";
const svg_theme_fill_color = "_svg_theme_fill_color_1rn4l_3";
const container = "_container_1rn4l_55";
const header = "_header_1rn4l_59";
const more = "_more_1rn4l_238";
const img = "_img_1rn4l_413";
const listContainer = "_listContainer_1rn4l_471";
const left_nav = "_left_nav_1rn4l_476";
const rightContainer = "_rightContainer_1rn4l_486";
const rightItem = "_rightItem_1rn4l_491";
const first = "_first_1rn4l_712";
const index = "_index_1rn4l_723";
const second = "_second_1rn4l_787";
const css = {
  svg_theme_fill_color,
  container,
  header,
  more,
  img,
  listContainer,
  left_nav,
  rightContainer,
  rightItem,
  first,
  index,
  second
};
const BackRate = () => {
  const { t, i18n } = useTranslation();
  const { info, theme, fetchRebateConfig } = useUserInfoStore();
  reactExports.useState([]);
  const [plat_type, setPlat_type] = reactExports.useState(3);
  const [data, setData] = reactExports.useState([]);
  const navigate = useNavigate();
  const { games, gameSortMap, gameOpenMap } = useGameStore();
  const [leftList, setLeftList] = reactExports.useState([]);
  const [activityMap, setActivityMap] = reactExports.useState([]);
  reactExports.useEffect(() => {
    getGamesNav().then(([res]) => {
      setActivityMap(res);
    });
  }, []);
  const getConfig = async (game_type) => {
    const [res, err] = await getRebateConfig({
      game_type
    });
    if (err)
      return;
    setData(res || []);
  };
  const handleClick = (id) => {
    setPlat_type(id);
  };
  reactExports.useEffect(() => {
    getConfig(plat_type);
  }, [plat_type]);
  reactExports.useEffect(() => {
    if (!activityMap.length)
      return;
    const newArr = [
      ...rebateTypes.sort((a, b) => {
        return (a.sort || gameSortMap[a.type] || 0) - (b.sort || gameSortMap[b.type] || 0);
      }).filter((item) => {
        var _a;
        const id = (_a = games.find((i) => i.name === item.type)) == null ? void 0 : _a.id;
        return activityMap.some((item2) => item2.id === id);
      }).map((item) => {
        var _a;
        return {
          label: item.text,
          icon: item.icon,
          value: (_a = games.find((game) => game.name === item.type)) == null ? void 0 : _a.id,
          IconsCom: item.IconsCom
        };
      })
    ];
    setLeftList(newArr);
  }, [games, activityMap]);
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.container, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.header, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { children: [
        t("获得优惠"),
        /* @__PURE__ */ jsxRuntimeExports.jsx("span", { children: (info == null ? void 0 : info.rebate_amount) && customToFixed(info.rebate_amount) || "0,00" })
      ] }),
      /* @__PURE__ */ jsxRuntimeExports.jsxs(
        "div",
        {
          className: css.more,
          onClick: () => {
            navigate("/record-betting?to=back-rate?tag=4");
          },
          children: [
            t("详情"),
            /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.img, children: /* @__PURE__ */ jsxRuntimeExports.jsx(MoreInMineIcon, {}) })
          ]
        }
      )
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.listContainer, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx(LeftNav, { className: css.left_nav, selectId: plat_type, dataList: leftList, onChange: handleClick }),
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.rightContainer, children: data.map((item, index2) => /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.rightItem, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.first, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: t("等级") }),
          /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.index, children: [
            "0",
            index2 + 1
          ] })
        ] }),
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.second, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { children: [
            /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: t("有效投注") }),
            /* @__PURE__ */ jsxRuntimeExports.jsxs("span", { children: [
              item.bet_amount,
              t("万"),
              "+"
            ] })
          ] }),
          /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { children: [
            /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: t("现金返还率") }),
            /* @__PURE__ */ jsxRuntimeExports.jsxs("span", { children: [
              item.rebate_amount,
              " ",
              /* @__PURE__ */ jsxRuntimeExports.jsxs("span", { children: [
                "/",
                t("万")
              ] })
            ] })
          ] })
        ] })
      ] }, index2)) })
    ] })
  ] });
};
export {
  BackRate as default
};
