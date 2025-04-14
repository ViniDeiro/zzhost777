import { K as jsxRuntimeExports, r as reactExports, w as useParams, q as useUserInfoStore, G as Cache, p as getQueryVariable, b5 as getPromoDetail, z as sendMessage, P as joinClass, R as Image, x as useNavigate, bm as getPromoApplyStatus, bn as getPromoRescueProfit, bo as postPromoApply, a7 as Message, aI as lodashExports, bp as getPromoDepositDetail } from "./index-a_Ow1xUN-2024_8_30_15_11.js";
import { l as useTranslation, u as useFlutterApp, A as ArrowLeftInMineIcon, B as Button } from "./App-D9NLPZJN-2024_8_30_15_11.js";
import { A as ActivityBottom } from "./index--6igQ1bG-2024_8_30_15_11.js";
import { l as lineImgMap } from "./map-C3EIoPQv-2024_8_30_15_11.js";
const svg_theme_fill_color = "_svg_theme_fill_color_502zp_3";
const activity = "_activity_502zp_55";
const app = "_app_502zp_71";
const title_img = "_title_img_502zp_74";
const container = "_container_502zp_97";
const edit_con = "_edit_con_502zp_100";
const headerContainer = "_headerContainer_502zp_105";
const back = "_back_502zp_195";
const ico = "_ico_502zp_201";
const title = "_title_502zp_74";
const operate = "_operate_502zp_292";
const btn = "_btn_502zp_302";
const btnDiv = "_btnDiv_502zp_312";
const center = "_center_502zp_332";
const imgList = "_imgList_502zp_339";
const rules_container = "_rules_container_502zp_343";
const tip = "_tip_502zp_343";
const line = "_line_502zp_348";
const c_activity_list = "_c_activity_list_502zp_418";
const tutorial_txt = "_tutorial_txt_502zp_732";
const tutorial_txt_top = "_tutorial_txt_top_502zp_765";
const drakColor = "_drakColor_502zp_769";
const rule_texts = "_rule_texts_502zp_820";
const rule_text_row = "_rule_text_row_502zp_824";
const css = {
  svg_theme_fill_color,
  activity,
  app,
  title_img,
  container,
  edit_con,
  headerContainer,
  back,
  ico,
  title,
  operate,
  btn,
  btnDiv,
  center,
  imgList,
  rules_container,
  tip,
  line,
  c_activity_list,
  tutorial_txt,
  tutorial_txt_top,
  drakColor,
  rule_texts,
  rule_text_row
};
const Table = ({ colums = [], data = [] }) => {
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.c_activity_list, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "c_activity_list_header c_activity_list_row", children: colums.map((col, index) => {
      return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "c_activity_list_col", children: col.title }, index);
    }) }),
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "c_activity_list_body", children: data.map((row, index) => {
      return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "c_activity_list_row", children: colums.map((col, i) => {
        return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "c_activity_list_col", children: col.render ? col.render(row) : col.format ? col.format(row) : row[col["field"]] }, i);
      }) }, index);
    }) })
  ] });
};
const BaseHeader$2 = ({ title: title2 = "-", right }) => {
  const navigate = useNavigate();
  useUserInfoStore();
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("header", { className: css.headerContainer, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsx(
      "div",
      {
        className: css.back,
        onClick: () => {
          navigate(-1);
        },
        children: /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.ico, children: /* @__PURE__ */ jsxRuntimeExports.jsx(ArrowLeftInMineIcon, {}) })
      }
    ),
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.title, children: /* @__PURE__ */ jsxRuntimeExports.jsx("span", { children: title2 }) }),
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.operate, children: right })
  ] });
};
const ActivityList$2 = ({
  setLoading,
  renderList,
  amount,
  id,
  getApplyStatus,
  applyStatusData,
  loading
}) => {
  const { t, i18n } = useTranslation();
  const { theme } = useUserInfoStore();
  async function handleApply() {
    if (loading)
      return;
    setLoading(true);
    const [res, error] = await postPromoApply({
      id,
      flag: "rescue",
      amount,
      bonus_type: 1
    });
    setLoading(false);
    if (error)
      return;
    if (!error) {
      Message.success(t("成功收到佣金"));
      getApplyStatus();
    }
  }
  return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "activity_list", children: renderList.map((item, index) => {
    return item ? /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.rules_container, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.tip, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.line, children: /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { src: lineImgMap[theme] || lineImgMap["default"] }) }),
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.title, children: item.title }),
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.line, children: /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { src: lineImgMap[theme] || lineImgMap["default"] }) })
      ] }),
      /* @__PURE__ */ jsxRuntimeExports.jsx(Table, { colums: item.colums, data: item.data })
    ] }, index) : /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.center, children: /* @__PURE__ */ jsxRuntimeExports.jsx(
      Button,
      {
        largeRound: true,
        disabled: amount === 0 || applyStatusData,
        onClick: handleApply,
        loading,
        className: css.btn,
        children: /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.btnDiv, children: t("进入") })
      }
    ) }, index);
  }) });
};
const Rescue = () => {
  const { t, i18n } = useTranslation();
  const [activityData, SetActivityData] = reactExports.useState([
    {
      title: t("活动详情"),
      colums: [
        {
          title: t("每日损失值"),
          field: "lose_amount"
        },
        {
          title: t("赎回价值"),
          render(row) {
            return /* @__PURE__ */ jsxRuntimeExports.jsx(jsxRuntimeExports.Fragment, { children: row.bonus_type === 2 ? row.bonus_rate + "%" : row.bonus_amount });
          }
        },
        {
          title: t("提款要求"),
          render(row) {
            return /* @__PURE__ */ jsxRuntimeExports.jsxs(jsxRuntimeExports.Fragment, { children: [
              "X",
              row.flow_multiple || 0
            ] });
          }
        }
      ],
      data: []
    }
  ]);
  const [title2, setTitle] = reactExports.useState("");
  const [headImg, setHeadImg] = reactExports.useState("");
  const { id, flag } = useParams();
  const [amountList, setAmountList] = reactExports.useState([]);
  const [profitValue, setProfitValue] = reactExports.useState(0);
  const [loading, setLoading] = reactExports.useState(false);
  const [applyStatusData, setApplyStatusData] = reactExports.useState(void 0);
  useUserInfoStore((state) => state);
  const { isApp } = useFlutterApp();
  const [ruleList, setRuleList] = reactExports.useState([]);
  const amount = reactExports.useMemo(() => {
    var _a;
    if (profitValue === 0)
      return 0;
    if (amountList.length === 0)
      return 0;
    return ((_a = amountList.find((item) => item.lose_amount <= Math.abs(+profitValue))) == null ? void 0 : _a.bonus_amount) || 0;
  }, [amountList, profitValue]);
  const getApplyStatus = async () => {
    const [res, error] = await getPromoApplyStatus({ id, flag });
    if (error)
      return;
    setApplyStatusData(res);
  };
  async function getRescueProfit() {
    const [res, error] = await getPromoRescueProfit();
    if (error)
      return;
    setProfitValue(res);
  }
  const renderList = reactExports.useMemo(() => {
    if (activityData.length === 0)
      return [];
    const data = [...activityData];
    data.splice(1, 0, "");
    return data;
  }, [activityData]);
  reactExports.useEffect(() => {
    if (Cache.get("token") || getQueryVariable("t")) {
      getApplyStatus();
      getRescueProfit();
    }
    getPromoDetail({ id, flag }).then(([res]) => {
      var _a, _b;
      if (!res)
        return;
      setTitle(((_a = res == null ? void 0 : res.config) == null ? void 0 : _a.title) || "");
      setRuleList(((_b = res == null ? void 0 : res.config) == null ? void 0 : _b.rule_text) || []);
      const details = activityData.map((item, index) => {
        return { ...item, data: JSON.parse(JSON.stringify(res.rules || [])) };
      });
      setHeadImg(res.static.title_h5);
      SetActivityData(details);
      if (res.rules) {
        setAmountList(res.rules.reverse());
      }
    });
  }, []);
  reactExports.useEffect(() => {
    if (isApp) {
      sendMessage("getTitleName", title2);
    }
  }, [title2]);
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: joinClass(css.activity, isApp ? css.app : ""), children: [
    !isApp && /* @__PURE__ */ jsxRuntimeExports.jsx(BaseHeader$2, { title: title2 }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.container, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.title_img, children: /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { src: headImg, remote: true, isGame: true }) }),
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.tutorial_txt, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.tutorial_txt_top, children: t("如果不幸的是") }),
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.tutorial_txt_bottom, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsxs("span", { className: css.drakColor, children: [
            t("奖金提交时间"),
            ":"
          ] }),
          /* @__PURE__ */ jsxRuntimeExports.jsxs("span", { children: [
            " ",
            t("次日凌晨1点起,报名领取")
          ] })
        ] })
      ] }),
      /* @__PURE__ */ jsxRuntimeExports.jsx(
        ActivityList$2,
        {
          setLoading,
          id,
          getApplyStatus,
          renderList,
          amount,
          applyStatusData,
          loading
        }
      ),
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.rule_texts, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.drakColor, children: [
          t("活动规则"),
          ":"
        ] }),
        ruleList.map((item, index) => {
          return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.rule_text_row, children: /* @__PURE__ */ jsxRuntimeExports.jsx("span", { children: item }) }, index);
        })
      ] })
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsx(ActivityBottom, {})
  ] });
};
const BaseHeader$1 = ({ title: title2 = "-", right }) => {
  const navigate = useNavigate();
  useUserInfoStore();
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("header", { className: css.headerContainer, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsx(
      "div",
      {
        className: css.back,
        onClick: () => {
          navigate(-1);
        },
        children: /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.ico, children: /* @__PURE__ */ jsxRuntimeExports.jsx(ArrowLeftInMineIcon, {}) })
      }
    ),
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.title, children: /* @__PURE__ */ jsxRuntimeExports.jsx("span", { children: title2 }) }),
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.operate, children: right })
  ] });
};
const ActivityList$1 = ({
  activityData,
  isManual,
  handleApply,
  obj,
  loading
}) => {
  const { t, i18n } = useTranslation();
  const { theme } = useUserInfoStore((state) => state);
  return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "activity_list", children: activityData.map((item, index) => {
    return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.rules_container, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.tip, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.line, children: /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { src: lineImgMap[theme] || lineImgMap["default"] }) }),
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.title, children: item.title }),
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.line, children: /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { src: lineImgMap[theme] || lineImgMap["default"] }) })
      ] }),
      /* @__PURE__ */ jsxRuntimeExports.jsx(Table, { colums: item.colums, data: item.data }),
      isManual && /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.center, children: /* @__PURE__ */ jsxRuntimeExports.jsx(
        Button,
        {
          disabled: !obj || (obj == null ? void 0 : obj.activeIndex) !== index + 1,
          largeRound: true,
          onClick: () => handleApply(index + 1),
          loading,
          className: css.btn,
          children: /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.btnDiv, children: t("进入") })
        }
      ) })
    ] }, index);
  }) });
};
const Deposit = () => {
  const { t, i18n } = useTranslation();
  const titleList = [
    t("首次存款活动"),
    t("二次存款活动"),
    t("第三次存款事件"),
    t("第四次存款事件"),
    t("第五次充值活动"),
    t("第六次充值活动"),
    t("第七次充值活动"),
    t("第八次充值活动"),
    t("第九次充值活动"),
    t("第十次充值活动")
  ];
  const [activityData, SetActivityData] = reactExports.useState([]);
  const [title2, setTitle] = reactExports.useState("");
  const [headImg, setHeadImg] = reactExports.useState("");
  const [data, setData] = reactExports.useState({});
  const { id, flag } = useParams();
  const [loading, setLoading] = reactExports.useState(false);
  const [applyStatusData, setApplyStatusData] = reactExports.useState(void 0);
  const [deposit, setDeposit] = reactExports.useState(void 0);
  const { token } = useUserInfoStore((state) => state);
  const [lv, setLv] = reactExports.useState(1);
  const { isApp } = useFlutterApp();
  const [isManual, setIsManual] = reactExports.useState(false);
  const [ruleList, setRuleList] = reactExports.useState([]);
  const [contentList, setContentList] = reactExports.useState([]);
  const rules = reactExports.useMemo(() => {
    return data == null ? void 0 : data.rules;
  }, [data]);
  const mergedInfo = reactExports.useMemo(() => {
    if (!applyStatusData || !deposit || !rules)
      return null;
    return lodashExports.zip(
      Object.values(applyStatusData),
      Object.values(deposit),
      Object.values(rules)
    ).map((item, index) => {
      return [...item, index + 1];
    });
  }, [applyStatusData, deposit, rules]);
  const getApplyStatus = async () => {
    const [res, error] = await getPromoApplyStatus({ id, flag });
    if (error)
      return;
    setApplyStatusData(res);
  };
  const getDepDetail = async () => {
    const [res, error] = await getPromoDepositDetail({ id, flag });
    if (error)
      return;
    setDeposit(res);
  };
  const obj = reactExports.useMemo(() => {
    if (!mergedInfo)
      return null;
    const activeIndex = mergedInfo.findIndex((item2) => item2[0] === false);
    if (activeIndex === -1)
      return null;
    const item = mergedInfo[activeIndex];
    const [, deposit2, rules2] = item;
    const sortedRules = rules2.sort(
      (a, b) => b.deposit_amount - a.deposit_amount
    );
    const index = sortedRules.findIndex((item2) => {
      return BigInt(item2.deposit_amount) <= BigInt(deposit2 != null ? deposit2 : 0);
    });
    const data2 = sortedRules[index];
    return activeIndex !== -1 && index !== -1 ? { data: data2, activeIndex: activeIndex + 1 } : null;
  }, [mergedInfo]);
  const applyData = reactExports.useMemo(() => {
    if (!(obj == null ? void 0 : obj.data)) {
      return null;
    }
    const { bonus_type, bonus_amount: amount, bonus_rate: rate } = obj.data;
    return bonus_type === 1 ? { id, flag, lv, bonus_type, amount } : { id, flag, lv, bonus_type, rate };
  }, [obj, lv]);
  function handleApply(val) {
    setLv(val);
    setTimeout(async () => {
      if (loading)
        return;
      setLoading(true);
      const [res, error] = await postPromoApply(
        Object.assign({}, applyData, { lv: val })
      );
      setLoading(false);
      if (error)
        return;
      if (!error) {
        Message.success(t("成功奖励"));
        getApplyStatus();
      } else {
        Message.error(t("失败奖励"));
      }
    }, 60);
  }
  reactExports.useEffect(() => {
    getPromoDetail({ id, flag }).then(([res]) => {
      var _a, _b, _c, _d;
      if (!res)
        return;
      setTitle(((_a = res == null ? void 0 : res.config) == null ? void 0 : _a.title) || "");
      setRuleList(((_b = res == null ? void 0 : res.config) == null ? void 0 : _b.rule_text) || []);
      setContentList(((_c = res == null ? void 0 : res.config) == null ? void 0 : _c.content_text) || []);
      const toArrRules = Object.values((res == null ? void 0 : res.rules) || {});
      const details = toArrRules == null ? void 0 : toArrRules.map((item, index) => {
        var _a2;
        return {
          title: titleList[index] || t("下次存款"),
          colums: [
            {
              title: t("初始存款金额"),
              field: "deposit_amount"
            },
            {
              //  // 由于第二列的值可能是比例，所以动态设置表格的标题
              title: ((_a2 = res == null ? void 0 : res.config) == null ? void 0 : _a2.bonus_type) === 2 ? t("比例") : t("奖金"),
              render(row) {
                var _a3;
                return /* @__PURE__ */ jsxRuntimeExports.jsx(jsxRuntimeExports.Fragment, { children: ((_a3 = res == null ? void 0 : res.config) == null ? void 0 : _a3.bonus_type) === 2 ? row.bonus_rate + "%" : row.bonus_amount });
              }
            },
            {
              title: t("流水要求"),
              render(row) {
                return /* @__PURE__ */ jsxRuntimeExports.jsxs(jsxRuntimeExports.Fragment, { children: [
                  "X",
                  row.flow_multiple || 0
                ] });
              }
            }
          ],
          data: JSON.parse(JSON.stringify(item || []))
        };
      });
      setHeadImg(res.static.title_h5);
      const curTip = ((_d = res.static) == null ? void 0 : _d.deposit_manual) == 2 || (res == null ? void 0 : res.deposit_manual) == 2;
      setIsManual(curTip);
      SetActivityData(details);
      setData(res || {});
    });
  }, []);
  reactExports.useEffect(() => {
    if (isManual) {
      if (token || getQueryVariable("t")) {
        getApplyStatus();
        getDepDetail();
      }
    }
  }, [token, isManual]);
  reactExports.useEffect(() => {
    if (isApp) {
      sendMessage("getTitleName", title2);
    }
  }, [title2]);
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: joinClass(css.activity, isApp ? css.app : ""), children: [
    !isApp && /* @__PURE__ */ jsxRuntimeExports.jsx(BaseHeader$1, { title: title2 }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.container, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.title_img, children: /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { src: headImg, remote: true, isGame: true }) }),
      /* @__PURE__ */ jsxRuntimeExports.jsx(
        ActivityList$1,
        {
          activityData,
          isManual,
          handleApply,
          obj,
          loading
        }
      ),
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.rule_texts, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.drakColor, children: [
          t("活动内容"),
          ":"
        ] }),
        contentList.map((item, index) => {
          return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.rule_text_row, children: /* @__PURE__ */ jsxRuntimeExports.jsx("span", { children: item }) }, index);
        })
      ] }),
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.rule_texts, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.drakColor, children: [
          t("活动规则"),
          ":"
        ] }),
        ruleList.map((item, index) => {
          return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.rule_text_row, children: /* @__PURE__ */ jsxRuntimeExports.jsx("span", { children: item }) }, index);
        })
      ] })
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsx(ActivityBottom, {})
  ] });
};
const ActivityList = ({ activityData }) => {
  return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "activity_list", children: activityData == null ? void 0 : activityData.map((item, index) => {
    return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "activity_list_item", children: /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { src: item, remote: true, isGame: true }) }, index);
  }) });
};
const BaseHeader = ({ title: title2 = "-", right }) => {
  const navigate = useNavigate();
  useUserInfoStore();
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("header", { className: css.headerContainer, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.back, onClick: () => {
      navigate(-1);
    }, children: /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.ico, children: /* @__PURE__ */ jsxRuntimeExports.jsx(ArrowLeftInMineIcon, {}) }) }),
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.title, children: /* @__PURE__ */ jsxRuntimeExports.jsx("span", { children: title2 }) }),
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.operate, children: right })
  ] });
};
const Static = () => {
  useTranslation();
  const [activityData, SetActivityData] = reactExports.useState([]);
  const [title2, setTitle] = reactExports.useState("");
  const [headImg, setHeadImg] = reactExports.useState("");
  const { id, flag } = useParams();
  reactExports.useState(false);
  const { isApp } = useFlutterApp();
  const [configData, SetConfigData] = reactExports.useState({});
  const [staticData, SetStaticData] = reactExports.useState({});
  reactExports.useEffect(() => {
    getPromoDetail({ id, flag }).then(([res]) => {
      var _a;
      console.log("--------------");
      if (!res)
        return;
      setTitle(((_a = res == null ? void 0 : res.config) == null ? void 0 : _a.title) || "");
      const details = res.config.h5_content;
      setHeadImg(res.static.title_h5);
      SetActivityData(details);
      SetConfigData(res.config);
      SetStaticData(res.static);
    });
  }, []);
  reactExports.useEffect(() => {
    if (isApp) {
      sendMessage("getTitleName", title2);
    }
  }, [title2]);
  return /* @__PURE__ */ jsxRuntimeExports.jsx(jsxRuntimeExports.Fragment, { children: /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: joinClass(css.activity, isApp ? css.app : ""), children: [
    !isApp && /* @__PURE__ */ jsxRuntimeExports.jsx(BaseHeader, { title: title2 }),
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.container, children: flag === "static" && (staticData == null ? void 0 : staticData.page_style) === "txt" ? /* @__PURE__ */ jsxRuntimeExports.jsx(
      "div",
      {
        className: css.edit_con,
        style: { overflowY: "auto", height: "100%" },
        dangerouslySetInnerHTML: { __html: configData == null ? void 0 : configData.list_richContent }
      }
    ) : /* @__PURE__ */ jsxRuntimeExports.jsx(ActivityList, { activityData }) }),
    /* @__PURE__ */ jsxRuntimeExports.jsx(ActivityBottom, {})
  ] }) });
};
const Promotion = () => {
  const { flag } = useParams();
  console.log("flag---", flag);
  if (flag === "rescue") {
    return /* @__PURE__ */ jsxRuntimeExports.jsx(Rescue, {});
  }
  if (flag === "deposit") {
    return /* @__PURE__ */ jsxRuntimeExports.jsx(Deposit, {});
  }
  return /* @__PURE__ */ jsxRuntimeExports.jsx(Static, {});
};
export {
  Promotion as default
};
