import { v as useUserInfoStore, r as reactExports, N as jsxRuntimeExports, T as trans, bM as getPromoInviteRecordDetail, I as getWebType, aD as useFloatPopShareStore, bN as _, t as getQueryVariable, a2 as minPxChip, a9 as Message, S as Image, Q as joinClass, ab as customToFixed, W as Modal, bO as getPromoInviteList, C as sendMessage, bP as postPromoInviteOpen, G as getLinkList, H as getMoneyUnit } from "./index-CKtHrVPI-2024_9_14_11_28.js";
import { l as useTranslation, V as CloseIconInMineIcon, r as Picker, o as Input, S as SearchToolIcon, O as Table, q as customFormatTimer, h as LoadMore, Q as InnerPageWithBackContext, u as useFlutterApp, W as browser, X as ShareInMineIcon, i as clipboardExports, R as RectCopyIcon, B as Button } from "./App-BLdT6wOK-2024_9_14_11_28.js";
import { A as ActivityBottom } from "./index-CynkFVAr-2024_9_14_11_28.js";
const svg_theme_fill_color = "_svg_theme_fill_color_2li9d_3";
const recommendBox = "_recommendBox_2li9d_55";
const btnColor = "_btnColor_2li9d_65";
const peopleNum = "_peopleNum_2li9d_70";
const num = "_num_2li9d_75";
const detail = "_detail_2li9d_239";
const condition = "_condition_2li9d_318";
const title = "_title_2li9d_427";
const list = "_list_2li9d_517";
const table = "_table_2li9d_520";
const amountColor = "_amountColor_2li9d_802";
const listPadding = "_listPadding_2li9d_809";
const listContent = "_listContent_2li9d_813";
const tip = "_tip_2li9d_925";
const disabled = "_disabled_2li9d_942";
const ico = "_ico_2li9d_950";
const receberContainer = "_receberContainer_2li9d_953";
const receber = "_receber_2li9d_953";
const mem_count = "_mem_count_2li9d_968";
const size2 = "_size2_2li9d_988";
const size3 = "_size3_2li9d_991";
const introduce = "_introduce_2li9d_1007";
const detailPop = "_detailPop_2li9d_1144";
const close = "_close_2li9d_1236";
const selectContent = "_selectContent_2li9d_1300";
const searchIcon = "_searchIcon_2li9d_1305";
const searchInput = "_searchInput_2li9d_1308";
const searchBox = "_searchBox_2li9d_1313";
const svgSearch = "_svgSearch_2li9d_1417";
const search_input = "_search_input_2li9d_1519";
const tipPop = "_tipPop_2li9d_1754";
const btn = "_btn_2li9d_65";
const coinContent = "_coinContent_2li9d_2027";
const canvasDom = "_canvasDom_2li9d_2037";
const rotateDom = "_rotateDom_2li9d_2045";
const scrollTable = "_scrollTable_2li9d_2058";
const state3Amount = "_state3Amount_2li9d_2094";
const baoxiang = "_baoxiang_2li9d_2108";
const dire = "_dire_2li9d_2111";
const dires = "_dires_2li9d_2189";
const baoxiang_avi = "_baoxiang_avi_2li9d_2276";
const item = "_item_2li9d_2294";
const shareContent = "_shareContent_2li9d_2298";
const state1Amount = "_state1Amount_2li9d_2302";
const bx_1 = "_bx_1_2li9d_2372";
const bx_2 = "_bx_2_2li9d_2378";
const bx_3 = "_bx_3_2li9d_2384";
const state2Amount = "_state2Amount_2li9d_2390";
const copy_icon = "_copy_icon_2li9d_3490";
const amount = "_amount_2li9d_802";
const is_active = "_is_active_2li9d_3602";
const not_active = "_not_active_2li9d_3624";
const css = {
  svg_theme_fill_color,
  recommendBox,
  btnColor,
  peopleNum,
  num,
  detail,
  condition,
  title,
  list,
  table,
  amountColor,
  listPadding,
  listContent,
  tip,
  disabled,
  ico,
  receberContainer,
  receber,
  mem_count,
  size2,
  size3,
  introduce,
  detailPop,
  close,
  selectContent,
  searchIcon,
  searchInput,
  searchBox,
  svgSearch,
  search_input,
  tipPop,
  btn,
  coinContent,
  canvasDom,
  rotateDom,
  scrollTable,
  state3Amount,
  baoxiang,
  dire,
  dires,
  baoxiang_avi,
  item,
  shareContent,
  state1Amount,
  bx_1,
  bx_2,
  bx_3,
  state2Amount,
  copy_icon,
  amount,
  is_active,
  not_active
};
const Detail = (props) => {
  const { i18n } = useTranslation();
  useUserInfoStore();
  const onClose = () => {
    props.onClose && props.onClose();
  };
  const [flag, setFlag] = reactExports.useState("0");
  const [dataSource, setDataSource] = reactExports.useState([]);
  const [page, setPage] = reactExports.useState(1);
  const [t, setT] = reactExports.useState(0);
  const [username, setUsername] = reactExports.useState("");
  const flagItems = [
    { label: i18n.t("全部"), value: "0" },
    { label: i18n.t("有效"), value: "1" },
    { label: i18n.t("无效"), value: "2" }
  ];
  const params = reactExports.useMemo(() => {
    return {
      flag,
      page,
      page_size: 10
    };
  }, [page, flag]);
  const [isLoading, setIsLoading] = reactExports.useState(false);
  const getList = async (username2) => {
    if (isLoading)
      return;
    const _params = Object.assign({}, params);
    if (username2) {
      _params.username = username2;
    }
    setIsLoading(true);
    const [res, error] = await getPromoInviteRecordDetail(_params, {
      useLoading: true
    });
    if (error)
      return;
    if (_params.page === 1) {
      setT(res.t);
    }
    setIsLoading(false);
    const _data = res.d || [];
    if (_params.page > 1) {
      setDataSource(dataSource.concat(_data));
    } else {
      setDataSource(_data);
    }
  };
  reactExports.useEffect(() => {
    getList(username);
  }, [params]);
  const limitClicks = () => {
    if (isLoading)
      return;
    setPage(page + 1);
  };
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.detailPop, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.close, onClick: onClose, children: /* @__PURE__ */ jsxRuntimeExports.jsx(CloseIconInMineIcon, {}) }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs(
      "div",
      {
        onClick: (e) => {
          e.stopPropagation();
        },
        children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("p", { className: css.title, children: i18n.t("我的推荐") }),
          /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.selectContent, children: [
            /* @__PURE__ */ jsxRuntimeExports.jsx(
              Picker,
              {
                items: flagItems,
                onChange: (_value) => {
                  setFlag(_value);
                }
              }
            ),
            /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.searchInput, children: /* @__PURE__ */ jsxRuntimeExports.jsx(
              Input,
              {
                placeholder: i18n.t("账户"),
                radius: true,
                suffix: /* @__PURE__ */ jsxRuntimeExports.jsx(
                  "div",
                  {
                    className: css.searchBox,
                    onClick: () => {
                      if (page === 1) {
                        getList(username);
                      } else {
                        setPage(1);
                      }
                    },
                    children: /* @__PURE__ */ jsxRuntimeExports.jsx(SearchToolIcon, { className: css.svgSearch })
                  }
                ),
                onChange: (val) => {
                  setUsername(val);
                }
              }
            ) })
          ] }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.scrollTable, children: /* @__PURE__ */ jsxRuntimeExports.jsx(
            Table,
            {
              columns: [
                {
                  title: i18n.t("下级帐户"),
                  dataIndex: "username",
                  render: (text, item2) => {
                    return /* @__PURE__ */ jsxRuntimeExports.jsx("span", { style: { fontWeight: "bold" }, children: item2.username });
                  }
                },
                {
                  title: i18n.t("参与时间"),
                  dataIndex: "created_at",
                  render: (text, item2) => {
                    return /* @__PURE__ */ jsxRuntimeExports.jsx("span", { children: customFormatTimer(text) });
                  }
                },
                {
                  title: i18n.t("有效与否"),
                  dataIndex: "is_active",
                  render: (text, item2) => {
                    return /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: item2.is_active ? css.is_active : css.not_active, style: { fontWeight: "bold" }, children: item2.is_active ? trans("是") : trans("否") });
                  }
                },
                {
                  title: i18n.t("有效条件"),
                  dataIndex: "username",
                  render: (text, item2) => {
                    return /* @__PURE__ */ jsxRuntimeExports.jsxs("span", { style: { fontWeight: "bold" }, children: [
                      i18n.t("累计充值"),
                      "：",
                      /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: css.amount, children: item2.deposit_amount }),
                      /* @__PURE__ */ jsxRuntimeExports.jsx("br", {}),
                      i18n.t("累计投注"),
                      "：",
                      /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: css.amount, children: item2.valid_bet_amount })
                    ] });
                  }
                }
              ],
              dataSource
            }
          ) }),
          t > dataSource.length && /* @__PURE__ */ jsxRuntimeExports.jsx(
            LoadMore,
            {
              onClick: () => {
                limitClicks();
              }
            }
          )
        ]
      }
    )
  ] });
};
const friendsState1Map = {
  black: "/activity/state1.webp"
};
const friendsState2Map = {
  black: "/activity/state2.webp"
};
const friendsState3Map = {
  black: "/activity/state3.webp"
};
function generateDireList(initIValue, addValue, count, step) {
  let arr = [];
  let arrIndex = 0;
  for (let i = initIValue; i < count; ) {
    if (!arr[arrIndex]) {
      arr.push([i]);
      i++;
      continue;
    }
    if (arr[arrIndex] && arr[arrIndex].length < step) {
      arr[arrIndex].push(i);
      i++;
      continue;
    }
    if (arr[arrIndex] && arr[arrIndex].length === step) {
      arrIndex++;
      i += addValue;
    }
  }
  return arr;
}
const listCount = 1e3;
const direList1 = generateDireList(1, 5, listCount, 3).flat();
const direList2 = generateDireList(4, 6, listCount, 2).flat();
const direList3 = generateDireList(6, 5, listCount, 3).flat();
const setDireStyle = (_index) => {
  let index = _index + 1;
  if (direList1.includes(index)) {
    return css.bx_1;
  }
  if (direList2.includes(index)) {
    return css.bx_2;
  }
  if (direList3.includes(index)) {
    return css.bx_3;
  }
};
const RecommendFriends = () => {
  const { t, i18n } = useTranslation();
  getWebType();
  const { setTitle } = reactExports.useContext(InnerPageWithBackContext);
  const { token, theme, agentUrl, getUserBalanceByStore } = useUserInfoStore(
    (state) => state
  );
  const { isApp } = useFlutterApp();
  const [detailStatus, setDetailStatus] = reactExports.useState(false);
  const [tipStatus, setTipStatus] = reactExports.useState(false);
  const { share } = useFloatPopShareStore();
  const [recharge, setRecharge] = reactExports.useState(0);
  const [bet, setBet] = reactExports.useState(0);
  const [num2, setNum] = reactExports.useState(0);
  const [dataList, setDataList] = reactExports.useState([]);
  const [openAmount, setOpenAmount] = reactExports.useState(0);
  const [shareUrl, setShareUrl] = reactExports.useState("");
  const [rules, setRules] = reactExports.useState([]);
  let loading = false;
  const renderDataList = reactExports.useMemo(() => {
    if (dataList.length === 0)
      return [];
    const sortDataList = dataList.sort((a, b) => a.sort - b.sort);
    const chunkList = _.chunk(sortDataList, 4);
    const maxMemCount = _.maxBy(sortDataList, "mem_count").mem_count;
    const modifiedArray = _.map(chunkList, (item2, index) => {
      if (item2.length < 4 && index % 2 !== 0) {
        const len = 4 - item2.length;
        for (let i = 0; i < len; i++) {
          item2.push({ state: 4, mem_count: +maxMemCount + (i + 1) });
        }
      }
      if (index % 2 === 0) {
        return item2;
      }
      return _.reverse(item2);
    });
    const fat = _.flatten(modifiedArray);
    for (let i = fat.length - 1; i >= 0; i--) {
      if (fat[i].state == 1) {
        fat[i] = {
          ...fat[i],
          color: theme === "whiteGreen" ? "#D9D9D9" : "#FFFFFF"
        };
      } else {
        fat[i] = { ...fat[i], color: "#D9D9D9" };
      }
    }
    if (fat.length) {
      const maxItemIndex = fat.findIndex(
        (item2) => +item2.mem_count === +maxMemCount
      );
      fat[maxItemIndex] = { ...fat[maxItemIndex], hidden: true };
    }
    let lastState2Index = 0;
    for (let i = 0; i < fat.length; i++) {
      if ([2, 3].includes(fat[i].state)) {
        lastState2Index = i;
      }
    }
    fat[lastState2Index] = { ...fat[lastState2Index], baoxiang_avi: true };
    return fat;
  });
  const getList = async () => {
    const [res, err] = await getPromoInviteList();
    if (err)
      return;
    setRecharge(res.deposit_limit);
    setBet(res.valid_bet_amount);
    setNum(res.total_mem_count);
    setDataList(res.list || []);
    setRules(res.promo_rule_json || []);
    setTitle(res.title);
    sendMessage("getTitleName", res.title);
  };
  const openInvite = async (item2, selector) => {
    if (loading)
      return;
    loading = true;
    const [res, err] = await postPromoInviteOpen({ mem_count: item2.mem_count });
    loading = false;
    if (err)
      return;
    setTimeout(() => {
      getUserBalanceByStore();
      setTipStatus(true);
      setOpenAmount(item2.bonus_amount);
      getList();
    }, 100);
  };
  const getLinkUrl = async () => {
    const [res, err] = await getLinkList();
    if (err)
      return;
    if (res && Array.isArray(res) && res.length > 0) {
      const url = "".concat(window.location.origin, "/?id=").concat(res[0].code, "&currency=").concat(getMoneyUnit(), "&type=2");
      setShareUrl(url);
    }
  };
  const nativeShare = async () => {
    if (navigator.share) {
      try {
        await navigator.share({
          title: "",
          text: "",
          url: shareUrl
        });
      } catch (error) {
        console.error("error", error);
      }
    } else {
      console.log("Web Share API 不受支持");
    }
  };
  const shareApp = (item2) => {
    sendMessage("onChatSystemMessage", "activity-".concat(item2.link));
  };
  const openWindow = (item2) => {
    window.open(item2.link.replace("xxxxx", encodeURIComponent(shareUrl)));
  };
  const directionIcon = (color = "#ffffff") => {
    return /* @__PURE__ */ jsxRuntimeExports.jsx(
      "svg",
      {
        width: "37",
        height: "36",
        viewBox: "0 0 37 36",
        fill: "none",
        xmlns: "http://www.w3.org/2000/svg",
        children: /* @__PURE__ */ jsxRuntimeExports.jsxs("g", { opacity: "0.5", children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx(
            "path",
            {
              d: "M3.66443 35.4264L19.3648 19.6352C19.4505 19.5672 19.5307 19.4908 19.6046 19.407C19.935 19.0302 20.1203 18.521 20.1203 17.9903C20.1203 17.4596 19.935 16.9504 19.6046 16.5737C19.53 16.489 19.4487 16.4119 19.362 16.3434L3.66443 0.555242C3.3317 0.194045 2.88723 -0.00524585 2.42614 0.00010503C1.96504 0.0054559 1.52411 0.21502 1.19799 0.583862C0.871872 0.952704 0.686565 1.45145 0.681671 1.97314C0.676777 2.49482 0.852726 2.9979 1.17185 3.37449L15.7031 17.9913L1.17185 32.6082C0.846188 32.9833 0.66468 33.4888 0.666767 34.0146C0.668854 34.5404 0.85424 35.044 1.18287 35.4158C1.51149 35.7877 1.95664 35.9976 2.42138 35.9999C2.88613 36.0023 3.33287 35.7969 3.66443 35.4284V35.4264Z",
              fill: "#D9D9D9"
            }
          ),
          /* @__PURE__ */ jsxRuntimeExports.jsx(
            "path",
            {
              d: "M20.2109 35.4265L35.9113 19.6353C35.997 19.5673 36.0772 19.4909 36.1511 19.407C36.4815 19.0303 36.6667 18.5211 36.6667 17.9904C36.6667 17.4597 36.4815 16.9505 36.1511 16.5737C36.0764 16.489 35.9952 16.412 35.9085 16.3435L20.2109 0.555286C19.8782 0.19409 19.4337 -0.00520155 18.9726 0.000149329C18.5115 0.0055002 18.0706 0.215064 17.7444 0.583906C17.4183 0.952748 17.233 1.4515 17.2281 1.97318C17.2232 2.49486 17.3992 2.99795 17.7183 3.37454L32.2495 17.9914L17.7183 32.6082C17.3926 32.9834 17.2111 33.4888 17.2132 34.0146C17.2153 34.5405 17.4007 35.0441 17.7293 35.4159C18.058 35.7877 18.5031 35.9976 18.9678 36C19.4326 36.0023 19.8793 35.7969 20.2109 35.4285V35.4265Z",
              fill: "#D9D9D9"
            }
          )
        ] })
      }
    );
  };
  reactExports.useEffect(() => {
    getList();
    if (token || getQueryVariable("t")) {
      getLinkUrl();
    } else {
      setShareUrl(window.location.origin);
    }
  }, [token]);
  reactExports.useEffect(() => {
    if (shareUrl) {
      browser.toCanvas(document.getElementById("qrcode"), shareUrl, {
        width: minPxChip() * 123.5,
        height: minPxChip() * 123.5,
        margin: 0
      });
    }
  }, [shareUrl]);
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.recommendBox, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: "share-box", children: [
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: "share-row1", children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "recommend_title", children: t("推荐信息") }),
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: "qr-container", children: [
          /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: "qr-box", children: [
            /* @__PURE__ */ jsxRuntimeExports.jsx("canvas", { className: "qr-code", id: "qrcode" }),
            /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "qr-text", children: t("点击保存") })
          ] }),
          /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: "share-input-box", children: [
            /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: "title", children: [
              t("推广链接"),
              /* @__PURE__ */ jsxRuntimeExports.jsx(
                "div",
                {
                  className: "share-icon",
                  onClick: () => {
                    nativeShare();
                  },
                  children: /* @__PURE__ */ jsxRuntimeExports.jsx(ShareInMineIcon, {})
                }
              )
            ] }),
            /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: "share-url", children: [
              /* @__PURE__ */ jsxRuntimeExports.jsx("span", { children: shareUrl }),
              /* @__PURE__ */ jsxRuntimeExports.jsx(
                "div",
                {
                  className: "".concat(css.copy_icon, " button"),
                  onClick: () => {
                    clipboardExports.copy(shareUrl);
                    Message.success(t("复制成功"));
                  },
                  children: /* @__PURE__ */ jsxRuntimeExports.jsx(RectCopyIcon, {})
                }
              )
            ] })
          ] })
        ] })
      ] }),
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: "chat-list", children: share.map((item2, index) => {
        const link = item2.link.replace("xxxxx", encodeURIComponent(shareUrl));
        return /* @__PURE__ */ jsxRuntimeExports.jsxs(
          "div",
          {
            className: "chat-app",
            onClick: (e) => {
              clipboardExports.copy(agentUrl);
              e.stopPropagation();
              isApp ? shareApp(item2) : openWindow(item2);
            },
            children: [
              /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { src: item2.img, isGame: true, remote: true }),
              /* @__PURE__ */ jsxRuntimeExports.jsx(
                "a",
                {
                  className: "app-title",
                  href: link,
                  id: "share-".concat(item2.name),
                  target: "_blank",
                  children: item2.name
                }
              )
            ]
          },
          index
        );
      }) }),
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.peopleNum, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsxs("p", { className: css.num, children: [
          t("有效下级人员"),
          " ",
          /* @__PURE__ */ jsxRuntimeExports.jsx("span", { children: num2 }),
          " ",
          t("人")
        ] }),
        (token || getQueryVariable("t")) && /* @__PURE__ */ jsxRuntimeExports.jsx(
          "span",
          {
            className: css.detail,
            onClick: (e) => {
              e.stopPropagation();
              setDetailStatus(true);
            },
            children: t("详情")
          }
        )
      ] })
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.condition, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx("p", { className: css.title, children: t("领取彩金所需条件如下") }),
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.list, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.table, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: t("下级累计充值") }),
          /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { children: [
            /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: css.amountColor, children: recharge }),
            " ",
            t("元或以上")
          ] })
        ] }),
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.table, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: t("下级累计投注") }),
          /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { children: [
            /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: css.amountColor, children: bet }),
            " ",
            t("元或以上")
          ] })
        ] })
      ] })
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.listPadding, children: /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.listContent, children: renderDataList.map((item2, index) => {
      switch (item2.state) {
        case 1:
          return /* @__PURE__ */ jsxRuntimeExports.jsxs(
            "div",
            {
              className: css.baoxiang,
              "data-state": item2.state,
              children: [
                /* @__PURE__ */ jsxRuntimeExports.jsx(
                  Image,
                  {
                    className: css.ico,
                    src: friendsState1Map[theme] || "/activity/state1.webp"
                  }
                ),
                /* @__PURE__ */ jsxRuntimeExports.jsxs("span", { className: joinClass(
                  css.mem_count,
                  item2.mem_count >= 10 && item2.mem_count < 1e3 ? css.size2 : "",
                  item2.mem_count >= 1e3 ? css.size3 : ""
                ), children: [
                  item2.mem_count,
                  item2.mem_count >= 1e3 && /* @__PURE__ */ jsxRuntimeExports.jsx("br", {}),
                  " ",
                  t("人")
                ] }),
                /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: css.state1Amount, children: customToFixed(item2.bonus_amount) }),
                item2.hidden !== true && /* @__PURE__ */ jsxRuntimeExports.jsx(
                  "span",
                  {
                    className: joinClass(
                      css.dire,
                      css.direstate1,
                      setDireStyle(index)
                    ),
                    children: directionIcon(item2.color)
                  }
                )
              ]
            },
            index
          );
        case 2:
          return /* @__PURE__ */ jsxRuntimeExports.jsxs(
            "div",
            {
              className: joinClass(css.baoxiang),
              onClick: () => {
                openInvite(item2, "canvas-".concat(item2.mem_count));
              },
              children: [
                /* @__PURE__ */ jsxRuntimeExports.jsx(
                  Image,
                  {
                    className: css.ico,
                    src: friendsState2Map[theme] || "/activity/state2.webp"
                  }
                ),
                /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.receberContainer, children: /* @__PURE__ */ jsxRuntimeExports.jsx("button", { className: joinClass(css.receber, "button"), children: t("领取") }) }),
                /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: css.state2Amount, children: customToFixed(item2.bonus_amount) }),
                item2.hidden !== true && /* @__PURE__ */ jsxRuntimeExports.jsx(
                  "span",
                  {
                    className: joinClass(
                      css.dire,
                      css.dires,
                      setDireStyle(index),
                      item2.baoxiang_avi ? css.baoxiang_avi : ""
                    ),
                    children: directionIcon(item2.color)
                  }
                )
              ]
            },
            index
          );
        case 3:
          return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: joinClass(css.baoxiang), children: [
            /* @__PURE__ */ jsxRuntimeExports.jsx(
              Image,
              {
                className: css.ico,
                src: friendsState3Map[theme] || "/activity/state3.webp"
              }
            ),
            /* @__PURE__ */ jsxRuntimeExports.jsxs("span", { className: joinClass(
              css.mem_count,
              item2.mem_count >= 10 && item2.mem_count < 1e3 ? css.size2 : "",
              item2.mem_count >= 1e3 ? css.size3 : ""
            ), children: [
              item2.mem_count,
              item2.mem_count >= 1e3 && /* @__PURE__ */ jsxRuntimeExports.jsx("br", {}),
              " ",
              t("人")
            ] }),
            /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: css.state3Amount, children: customToFixed(item2.bonus_amount) }),
            /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.disabled }),
            item2.hidden !== true && /* @__PURE__ */ jsxRuntimeExports.jsx(
              "span",
              {
                className: joinClass(
                  css.dire,
                  css.dires,
                  setDireStyle(index),
                  item2.baoxiang_avi ? css.baoxiang_avi : ""
                ),
                children: directionIcon(item2.color)
              }
            )
          ] }, index);
        default:
          return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.baoxiang }, index);
      }
    }) }) }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.introduce, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsxs("p", { children: [
        t("活动说明"),
        "："
      ] }),
      rules.map((item2, index) => {
        return /* @__PURE__ */ jsxRuntimeExports.jsxs("p", { children: [
          index + 1,
          ",",
          item2.content
        ] }, index);
      })
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsx(ActivityBottom, {}),
    /* @__PURE__ */ jsxRuntimeExports.jsx(Modal, { isOpen: detailStatus, onClose: (e) => e && e.stopPropagation(), children: /* @__PURE__ */ jsxRuntimeExports.jsx(
      Detail,
      {
        onClose: () => {
          setDetailStatus(false);
        }
      }
    ) }),
    /* @__PURE__ */ jsxRuntimeExports.jsx(Modal, { isOpen: tipStatus, onClose: (e) => e && e.stopPropagation(), children: /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.tipPop, children: /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx("p", { className: css.title, children: t("提示信息") }),
      /* @__PURE__ */ jsxRuntimeExports.jsx(
        "div",
        {
          className: css.close,
          onClick: (e) => {
            e.stopPropagation();
            setTipStatus(false);
          },
          children: /* @__PURE__ */ jsxRuntimeExports.jsx(CloseIconInMineIcon, {})
        }
      ),
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.coinContent, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { src: "/home/icons/activity_coin.webp" }),
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          "p",
          {
            className: css.tip,
            dangerouslySetInnerHTML: {
              __html: "".concat(t("恭喜您成功收到"), "  <span>").concat(openAmount, "</span>")
            }
          }
        )
      ] }),
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.btn, children: /* @__PURE__ */ jsxRuntimeExports.jsx(
        Button,
        {
          block: true,
          className: css.btnColor,
          onClick: () => {
            setTipStatus(false);
          },
          children: t("知道了")
        }
      ) })
    ] }) }) })
  ] });
};
export {
  RecommendFriends as default
};
