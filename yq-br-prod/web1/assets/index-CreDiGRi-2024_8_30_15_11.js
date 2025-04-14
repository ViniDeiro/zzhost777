import { r as reactExports, B as useGameStore, bl as getPromoMap, S as trans, K as jsxRuntimeExports, q as useUserInfoStore, x as useNavigate, R as Image } from "./index-a_Ow1xUN-2024_8_30_15_11.js";
import { G as GameTabs, k as LeftNav } from "./App-D9NLPZJN-2024_8_30_15_11.js";
import { TudoIcons } from "./Tudos-Bq9UPBqF-2024_8_30_15_11.js";
import { u as useActivityNavigate } from "./util-voEpZeRQ-2024_8_30_15_11.js";
const svg_theme_fill_color = "_svg_theme_fill_color_1pbw1_3";
const activity = "_activity_1pbw1_55";
const left_nav = "_left_nav_1pbw1_62";
const css = {
  svg_theme_fill_color,
  activity,
  left_nav
};
const ActivityList = ({ activityData }) => {
  const { token, getWheelInfo, wheelInfo, isSetWithdrawPassword } = useUserInfoStore((state) => state);
  const navigate = useNavigate();
  const { switchPage } = useActivityNavigate();
  const onClickToLink = (link) => {
    if (link === "web_login" || link === "登录") {
      if (token) {
        return;
      }
      useUserInfoStore.setState({ openForLogin: true });
      return;
    }
    if (link === "web_reg" || link === "注册") {
      if (token) {
        return;
      }
      useUserInfoStore.setState({ openForRegister: true });
      return;
    }
    if (link === "web_agent" || link === "推广") {
      navigate("/agent");
      return;
    }
    if (link === "web_deposit" || link === "充值") {
      navigate("/deposit");
      return;
    }
    if (link === "web_withdraw" || link === "提现") {
      if (isSetWithdrawPassword) {
        navigate("/withdraw");
      } else {
        navigate("/set-withdraw-psw?to=withdraw");
      }
      return;
    }
    if (link === "web_service" || link === "客服") {
      navigate("/message?service=1");
      return;
    }
    if (link === "web_vip" || link === "VIP") {
      navigate("/vip");
      return;
    }
    if (link === "web_mine" || link === "个人中心") {
      navigate("/mine");
      return;
    }
    navigate(link);
  };
  const itemClick = (item) => {
    var _a, _b, _c, _d;
    console.log(item, "===22222222222222222");
    if (((_a = item.static) == null ? void 0 : _a.display_mode) === 2) {
      if (((_b = item.static) == null ? void 0 : _b.link_url.indexOf("http")) > -1) {
        window.open((_c = item.static) == null ? void 0 : _c.link_url);
        return;
      } else {
        const curObj = activityData.find((ttt) => {
          var _a2;
          return ttt.id === ((_a2 = item.static) == null ? void 0 : _a2.link_url);
        });
        if (curObj) {
          item = { ...curObj };
          return switchPage(item);
        } else {
          return onClickToLink((_d = item.static) == null ? void 0 : _d.link_url);
        }
      }
    }
    switchPage(item);
  };
  return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "activity_list", children: activityData.map((item, index) => {
    return /* @__PURE__ */ jsxRuntimeExports.jsx(
      "div",
      {
        className: "activity_list_item",
        onClick: () => {
          itemClick(item);
        },
        children: /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { src: item.static.list_h5, remote: true, isGame: true })
      },
      index
    );
  }) });
};
const Promotion = () => {
  const [leftList, setLeftList] = reactExports.useState([]);
  const { games, gameSortMap, activityList: activityData } = useGameStore();
  const [activityMap, setActivityMap] = reactExports.useState({});
  reactExports.useEffect(() => {
    getPromoMap().then(([res]) => {
      setActivityMap(res);
    });
  }, []);
  reactExports.useEffect(() => {
    setLeftList([
      {
        value: "-1",
        label: "".concat(trans("全部")),
        IconsCom: TudoIcons
      },
      ...GameTabs.sort((a, b) => {
        return (a.sort || gameSortMap[a.type] || 0) - (b.sort || gameSortMap[b.type] || 0);
      }).filter((item) => {
        var _a;
        console.log(" i.name === item.type :>> ", games, item.type);
        const id = (_a = games.find((i) => i.name === item.type)) == null ? void 0 : _a.id;
        return Object.keys(activityMap).includes(String(id));
      }).map((item) => {
        var _a;
        return {
          label: item.text,
          icon: item.icon,
          value: (_a = games.find((game) => game.name === item.type)) == null ? void 0 : _a.id,
          IconsCom: item.IconsCom
        };
      })
    ]);
  }, [games, activityMap]);
  const [nav, setNav] = reactExports.useState(null);
  console.log("leftList :>> ", leftList);
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.activity, children: [
    leftList && leftList.length > 0 && /* @__PURE__ */ jsxRuntimeExports.jsx(LeftNav, { className: css.left_nav, dataList: leftList, onChange: setNav }),
    /* @__PURE__ */ jsxRuntimeExports.jsx(ActivityList, { activityData: activityMap[nav] || activityData })
  ] });
};
export {
  Promotion as default
};
