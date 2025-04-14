import { r as reactExports, K as jsxRuntimeExports, P as joinClass, E as getMoneyUnit, aa as customToFixed, q as useUserInfoStore, V as dayjs, ab as getMemberRecordTrade } from "./index-a_Ow1xUN-2024_8_30_15_11.js";
import { l as useTranslation, ag as DownIcon, aa as Empty, p as customFormatTimer, h as useSetState, i as LoadMore } from "./App-D9NLPZJN-2024_8_30_15_11.js";
function numAdd(num1, num2) {
  var baseNum, baseNum1, baseNum2;
  try {
    baseNum1 = num1.toString().split(".")[1].length;
  } catch (e) {
    baseNum1 = 0;
  }
  try {
    baseNum2 = num2.toString().split(".")[1].length;
  } catch (e) {
    baseNum2 = 0;
  }
  baseNum = Math.pow(10, Math.max(baseNum1, baseNum2));
  return (num1 * baseNum + num2 * baseNum) / baseNum;
}
const svg_theme_fill_color$2 = "_svg_theme_fill_color_1ia3m_3";
const bonus = "_bonus_1ia3m_55";
const header = "_header_1ia3m_55";
const moneyLabel = "_moneyLabel_1ia3m_63";
const totalMoney = "_totalMoney_1ia3m_128";
const normalBtn = "_normalBtn_1ia3m_193";
const bonusTableBox = "_bonusTableBox_1ia3m_210";
const css$2 = {
  svg_theme_fill_color: svg_theme_fill_color$2,
  bonus,
  header,
  moneyLabel,
  totalMoney,
  normalBtn,
  bonusTableBox
};
const svg_theme_fill_color$1 = "_svg_theme_fill_color_1k08i_3";
const selectContainer = "_selectContainer_1k08i_55";
const noBg = "_noBg_1k08i_160";
const small = "_small_1k08i_166";
const noBorder = "_noBorder_1k08i_169";
const select = "_select_1k08i_55";
const content = "_content_1k08i_182";
const prefix = "_prefix_1k08i_244";
const suffix = "_suffix_1k08i_249";
const up = "_up_1k08i_319";
const down = "_down_1k08i_322";
const options = "_options_1k08i_325";
const option = "_option_1k08i_325";
const active = "_active_1k08i_593";
const css$1 = {
  svg_theme_fill_color: svg_theme_fill_color$1,
  selectContainer,
  noBg,
  "default": "_default_1k08i_163",
  small,
  noBorder,
  select,
  content,
  prefix,
  suffix,
  up,
  down,
  options,
  option,
  active
};
const NewSelect = (props) => {
  const { t, i18n } = useTranslation();
  const { value } = props;
  const [showOptions, setShowOptions] = reactExports.useState(false);
  const renderValue = reactExports.useMemo(() => {
    if (props.items === void 0)
      return "";
    const item = props.items.find((_) => _.value === value);
    return item ? t(item.label) : "";
  }, [value, props.items]);
  const clickHandler = (_value) => {
    setShowOptions(false);
    props.onChange && props.onChange(_value);
  };
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: joinClass(css$1.selectContainer, props.noBg ? css$1.noBg : ""), onClick: () => setShowOptions(!showOptions), children: [
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$1.select, children: /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$1.content, children: renderValue }) }),
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$1.suffix, children: /* @__PURE__ */ jsxRuntimeExports.jsx(DownIcon, { className: joinClass(showOptions ? css$1.up : css$1.down), src: "/home/icons/down.webp" }) }),
    showOptions && props.items && /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: joinClass(css$1.options), children: props.items.map((_, index) => {
      return /* @__PURE__ */ jsxRuntimeExports.jsx(
        "div",
        {
          className: joinClass(css$1.option, value === _.value ? css$1.active : ""),
          onClick: (e) => {
            e.stopPropagation();
            clickHandler(_.value);
          },
          children: t(_.label)
        },
        index
      );
    }) })
  ] });
};
const svg_theme_fill_color = "_svg_theme_fill_color_sqf34_3";
const alreadyGetbonus_list = "_alreadyGetbonus_list_sqf34_55";
const css = {
  svg_theme_fill_color,
  alreadyGetbonus_list
};
const List = ({ data = [] }) => {
  const { t, i18n } = useTranslation();
  const formatFlag = (flag) => {
    const resEl = flagItems.find((item) => +item.value === flag);
    return resEl.value === "279" ? t("任务奖励") : t(resEl.label);
  };
  const getLabel = {
    211: t("platformBonusSite"),
    212: t("upgradeBonus"),
    213: t("birthdayBonus"),
    214: t("monthlyBonus"),
    215: t("redPacketBonus"),
    216: t("maintenanceCompensation"),
    217: t("depositDiscount"),
    218: t("eventBonus"),
    219: t("referralBonus"),
    220: t("bonusAdjustment"),
    221: t("venueBalanceNegativeClearance"),
    222: t("agentBonus"),
    223: t("taskBonus")
  };
  return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.alreadyGetbonus_list, children: data.length === 0 ? /* @__PURE__ */ jsxRuntimeExports.jsx(Empty, { type: 2 }) : data.map((item, index) => {
    return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: "alreadyGetbonus_list_row", children: [
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: "context_box", children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "title", children: item.ptitle ? item.ptitle : getLabel[item.ty] || "" }),
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: "alreadyGetbonus_list__container", children: [
          /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: "alreadyGetbonus_list_bonus", children: [
            /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: "alreadyGetbonus_list_RS", children: getMoneyUnit(true) }),
            /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: "bonus", children: customToFixed(item.amount) })
          ] }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "alreadyGetbonus_list_date", children: customFormatTimer(item.created_at * 1e3, "MM/DD/YYYY") }),
          /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: "alreadyGetbonus_list_status", children: [
            /* @__PURE__ */ jsxRuntimeExports.jsxs("span", { children: [
              t("来源"),
              ": "
            ] }),
            /* @__PURE__ */ jsxRuntimeExports.jsx("span", { children: formatFlag(item.flag) })
          ] })
        ] })
      ] }),
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "alreadyGetbonus_list_btn", children: t("已完成") })
    ] }, index);
  }) });
};
const selectOPtions = [
  { value: 0, label: "今日" },
  { value: 1, label: "昨日" },
  { value: 7, label: "近7日" },
  { value: 15, label: "近15日" },
  { value: 30, label: "近30日" },
  { value: 60, label: "近60日" }
];
const flagItems = [
  // { label: t('存款'), value: '271' },
  // { label: t('取款'), value: '272' },
  // { label: t('转账'), value: '273' },
  { label: "奖金", value: "274" },
  // { label: t('佣金返水'), value: '275' },
  // { label: t('调整'), value: '278' },
  { label: "任务", value: "279" }
];
const AlreadyGetbonus = () => {
  const { t, i18n } = useTranslation();
  const windowSearch = window.location.search;
  const getParams = new URLSearchParams(windowSearch);
  const defaultFlag = getParams.get("flag") || "274";
  const [value, setValue] = reactExports.useState(0);
  const [page, setPage] = reactExports.useState(1);
  useUserInfoStore();
  const [total, setTotal] = reactExports.useState(0);
  const [thisState, setThisState] = useSetState({
    start_time: "",
    end_time: "",
    totalMoney: 0
  });
  const { start_time, end_time, totalMoney: totalMoney2 } = thisState;
  const [params, setParams] = reactExports.useState({
    ty: "0",
    flag: defaultFlag,
    page_size: 15
  });
  const [data, setData] = reactExports.useState([]);
  const getList = async () => {
    if (page === 1) {
      setTotal(0);
    }
    if (!start_time)
      return;
    const [res, err] = await getMemberRecordTrade({
      ...params,
      page,
      start_time,
      end_time,
      state: 1
    });
    if (page === 1) {
      setTotal(res.t);
      setData(res.d || []);
      return;
    }
    setData([...data, ...res.d]);
  };
  const search = () => {
    if (page !== 1) {
      setData([]);
      setPage(1);
    } else {
      getList();
    }
  };
  reactExports.useEffect(() => {
    setThisState({
      start_time: dayjs().subtract(value, "day").format("YYYY-MM-DD") + " 00:00:00",
      end_time: dayjs().format("YYYY-MM-DD") + " 23:59:59"
    });
  }, [value]);
  reactExports.useEffect(() => {
    search();
  }, [start_time, params.flag]);
  reactExports.useEffect(() => {
    if (start_time) {
      getList();
    }
  }, [page]);
  reactExports.useEffect(() => {
    let count = 0;
    data.forEach((item) => {
      count = numAdd(count, item.amount);
    });
    setThisState({ totalMoney: count });
  }, [data]);
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$2.bonus, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$2.header, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx(
        NewSelect,
        {
          items: selectOPtions,
          value,
          onChange: (_v) => {
            setValue(_v);
          }
        }
      ),
      /* @__PURE__ */ jsxRuntimeExports.jsx(
        NewSelect,
        {
          items: flagItems,
          value: params.flag,
          onChange: (_value) => {
            setParams({
              ...params,
              flag: _value
            });
          }
        }
      ),
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$2.totalMoney, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: css$2.moneyLabel, children: t("奖金") }),
        /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: css$2.totalMoney, children: customToFixed(totalMoney2) })
      ] })
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.bonusTableBox, children: /* @__PURE__ */ jsxRuntimeExports.jsx(List, { data }) }),
    total > data.length && /* @__PURE__ */ jsxRuntimeExports.jsx(
      LoadMore,
      {
        onClick: () => {
          setPage(page + 1);
        }
      }
    )
  ] });
};
export {
  AlreadyGetbonus as default,
  flagItems
};
