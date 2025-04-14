import { r as reactExports, T as React, M as reactDomExports, aj as events, K as jsxRuntimeExports, P as joinClass, S as trans, a7 as Message$1, x as useNavigate, C as useMessageStore, q as useUserInfoStore, G as Cache, bx as readUserMessage, R as Image, b6 as getNoticeList, by as withdrawFeedback, bz as listFeedback, bA as addFeedback, L as getMemberCustomerList, bB as getMessageList, bC as deleteUserMessage } from "./index-a_Ow1xUN-2024_8_30_15_11.js";
import { z as Icon, _ as _extends, E as _slicedToArray, J as classNames, K as _defineProperty, N as _typeof, O as CSSMotionList, Q as _objectWithoutProperties, R as _objectSpread2, V as _toConsumableArray, X as genStyleHooks, Y as merge, Z as Keyframe, $ as resetComponent, a0 as CONTAINER_MAX_OFFSET, a1 as ConfigContext, a2 as useCSSVarCls, a3 as RefIcon$3, a4 as RefIcon$4, a5 as RefIcon$5, a6 as render, a7 as ConfigProvider, a8 as globalConfig, l as useTranslation, A as ArrowLeftInMineIcon, a9 as InputClearIcon, aa as Empty, p as customFormatTimer, d as useReactive, e as useAsyncEffect, j as clipboardExports, ab as RectCopyIcon, B as Button, i as LoadMore } from "./App-D9NLPZJN-2024_8_30_15_11.js";
import { DeleteIcon } from "./Delete-Cgx9NjxU-2024_8_30_15_11.js";
import { MessageSetIcon } from "./MessageSet-B9Um2_sV-2024_8_30_15_11.js";
import { SelectIcon } from "./Select-BL-vF3FW-2024_8_30_15_11.js";
import { MessageVolumIcon } from "./MessageVolum-DhM4RQbH-2024_8_30_15_11.js";
import { S as Spin } from "./index-CJRkgAoO-2024_8_30_15_11.js";
import { S as S3PutObject } from "./s3-CXhGbR_j-2024_8_30_15_11.js";
var CheckCircleFilled$1 = { "icon": { "tag": "svg", "attrs": { "viewBox": "64 64 896 896", "focusable": "false" }, "children": [{ "tag": "path", "attrs": { "d": "M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm193.5 301.7l-210.6 292a31.8 31.8 0 01-51.7 0L318.5 484.9c-3.8-5.3 0-12.7 6.5-12.7h46.9c10.2 0 19.9 4.9 25.9 13.3l71.2 98.8 157.2-218c6-8.3 15.6-13.3 25.9-13.3H699c6.5 0 10.3 7.4 6.5 12.7z" } }] }, "name": "check-circle", "theme": "filled" };
var CheckCircleFilled = function CheckCircleFilled2(props, ref) {
  return /* @__PURE__ */ reactExports.createElement(Icon, _extends({}, props, {
    ref,
    icon: CheckCircleFilled$1
  }));
};
var RefIcon$2 = /* @__PURE__ */ reactExports.forwardRef(CheckCircleFilled);
var ExclamationCircleFilled$1 = { "icon": { "tag": "svg", "attrs": { "viewBox": "64 64 896 896", "focusable": "false" }, "children": [{ "tag": "path", "attrs": { "d": "M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm-32 232c0-4.4 3.6-8 8-8h48c4.4 0 8 3.6 8 8v272c0 4.4-3.6 8-8 8h-48c-4.4 0-8-3.6-8-8V296zm32 440a48.01 48.01 0 010-96 48.01 48.01 0 010 96z" } }] }, "name": "exclamation-circle", "theme": "filled" };
var ExclamationCircleFilled = function ExclamationCircleFilled2(props, ref) {
  return /* @__PURE__ */ reactExports.createElement(Icon, _extends({}, props, {
    ref,
    icon: ExclamationCircleFilled$1
  }));
};
var RefIcon$1 = /* @__PURE__ */ reactExports.forwardRef(ExclamationCircleFilled);
var InfoCircleFilled$1 = { "icon": { "tag": "svg", "attrs": { "viewBox": "64 64 896 896", "focusable": "false" }, "children": [{ "tag": "path", "attrs": { "d": "M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm32 664c0 4.4-3.6 8-8 8h-48c-4.4 0-8-3.6-8-8V456c0-4.4 3.6-8 8-8h48c4.4 0 8 3.6 8 8v272zm-32-344a48.01 48.01 0 010-96 48.01 48.01 0 010 96z" } }] }, "name": "info-circle", "theme": "filled" };
var InfoCircleFilled = function InfoCircleFilled2(props, ref) {
  return /* @__PURE__ */ reactExports.createElement(Icon, _extends({}, props, {
    ref,
    icon: InfoCircleFilled$1
  }));
};
var RefIcon = /* @__PURE__ */ reactExports.forwardRef(InfoCircleFilled);
var KeyCode = {
  /**
   * MAC_ENTER
   */
  MAC_ENTER: 3,
  /**
   * BACKSPACE
   */
  BACKSPACE: 8,
  /**
   * TAB
   */
  TAB: 9,
  /**
   * NUMLOCK on FF/Safari Mac
   */
  NUM_CENTER: 12,
  // NUMLOCK on FF/Safari Mac
  /**
   * ENTER
   */
  ENTER: 13,
  /**
   * SHIFT
   */
  SHIFT: 16,
  /**
   * CTRL
   */
  CTRL: 17,
  /**
   * ALT
   */
  ALT: 18,
  /**
   * PAUSE
   */
  PAUSE: 19,
  /**
   * CAPS_LOCK
   */
  CAPS_LOCK: 20,
  /**
   * ESC
   */
  ESC: 27,
  /**
   * SPACE
   */
  SPACE: 32,
  /**
   * PAGE_UP
   */
  PAGE_UP: 33,
  // also NUM_NORTH_EAST
  /**
   * PAGE_DOWN
   */
  PAGE_DOWN: 34,
  // also NUM_SOUTH_EAST
  /**
   * END
   */
  END: 35,
  // also NUM_SOUTH_WEST
  /**
   * HOME
   */
  HOME: 36,
  // also NUM_NORTH_WEST
  /**
   * LEFT
   */
  LEFT: 37,
  // also NUM_WEST
  /**
   * UP
   */
  UP: 38,
  // also NUM_NORTH
  /**
   * RIGHT
   */
  RIGHT: 39,
  // also NUM_EAST
  /**
   * DOWN
   */
  DOWN: 40,
  // also NUM_SOUTH
  /**
   * PRINT_SCREEN
   */
  PRINT_SCREEN: 44,
  /**
   * INSERT
   */
  INSERT: 45,
  // also NUM_INSERT
  /**
   * DELETE
   */
  DELETE: 46,
  // also NUM_DELETE
  /**
   * ZERO
   */
  ZERO: 48,
  /**
   * ONE
   */
  ONE: 49,
  /**
   * TWO
   */
  TWO: 50,
  /**
   * THREE
   */
  THREE: 51,
  /**
   * FOUR
   */
  FOUR: 52,
  /**
   * FIVE
   */
  FIVE: 53,
  /**
   * SIX
   */
  SIX: 54,
  /**
   * SEVEN
   */
  SEVEN: 55,
  /**
   * EIGHT
   */
  EIGHT: 56,
  /**
   * NINE
   */
  NINE: 57,
  /**
   * QUESTION_MARK
   */
  QUESTION_MARK: 63,
  // needs localization
  /**
   * A
   */
  A: 65,
  /**
   * B
   */
  B: 66,
  /**
   * C
   */
  C: 67,
  /**
   * D
   */
  D: 68,
  /**
   * E
   */
  E: 69,
  /**
   * F
   */
  F: 70,
  /**
   * G
   */
  G: 71,
  /**
   * H
   */
  H: 72,
  /**
   * I
   */
  I: 73,
  /**
   * J
   */
  J: 74,
  /**
   * K
   */
  K: 75,
  /**
   * L
   */
  L: 76,
  /**
   * M
   */
  M: 77,
  /**
   * N
   */
  N: 78,
  /**
   * O
   */
  O: 79,
  /**
   * P
   */
  P: 80,
  /**
   * Q
   */
  Q: 81,
  /**
   * R
   */
  R: 82,
  /**
   * S
   */
  S: 83,
  /**
   * T
   */
  T: 84,
  /**
   * U
   */
  U: 85,
  /**
   * V
   */
  V: 86,
  /**
   * W
   */
  W: 87,
  /**
   * X
   */
  X: 88,
  /**
   * Y
   */
  Y: 89,
  /**
   * Z
   */
  Z: 90,
  /**
   * META
   */
  META: 91,
  // WIN_KEY_LEFT
  /**
   * WIN_KEY_RIGHT
   */
  WIN_KEY_RIGHT: 92,
  /**
   * CONTEXT_MENU
   */
  CONTEXT_MENU: 93,
  /**
   * NUM_ZERO
   */
  NUM_ZERO: 96,
  /**
   * NUM_ONE
   */
  NUM_ONE: 97,
  /**
   * NUM_TWO
   */
  NUM_TWO: 98,
  /**
   * NUM_THREE
   */
  NUM_THREE: 99,
  /**
   * NUM_FOUR
   */
  NUM_FOUR: 100,
  /**
   * NUM_FIVE
   */
  NUM_FIVE: 101,
  /**
   * NUM_SIX
   */
  NUM_SIX: 102,
  /**
   * NUM_SEVEN
   */
  NUM_SEVEN: 103,
  /**
   * NUM_EIGHT
   */
  NUM_EIGHT: 104,
  /**
   * NUM_NINE
   */
  NUM_NINE: 105,
  /**
   * NUM_MULTIPLY
   */
  NUM_MULTIPLY: 106,
  /**
   * NUM_PLUS
   */
  NUM_PLUS: 107,
  /**
   * NUM_MINUS
   */
  NUM_MINUS: 109,
  /**
   * NUM_PERIOD
   */
  NUM_PERIOD: 110,
  /**
   * NUM_DIVISION
   */
  NUM_DIVISION: 111,
  /**
   * F1
   */
  F1: 112,
  /**
   * F2
   */
  F2: 113,
  /**
   * F3
   */
  F3: 114,
  /**
   * F4
   */
  F4: 115,
  /**
   * F5
   */
  F5: 116,
  /**
   * F6
   */
  F6: 117,
  /**
   * F7
   */
  F7: 118,
  /**
   * F8
   */
  F8: 119,
  /**
   * F9
   */
  F9: 120,
  /**
   * F10
   */
  F10: 121,
  /**
   * F11
   */
  F11: 122,
  /**
   * F12
   */
  F12: 123,
  /**
   * NUMLOCK
   */
  NUMLOCK: 144,
  /**
   * SEMICOLON
   */
  SEMICOLON: 186,
  // needs localization
  /**
   * DASH
   */
  DASH: 189,
  // needs localization
  /**
   * EQUALS
   */
  EQUALS: 187,
  // needs localization
  /**
   * COMMA
   */
  COMMA: 188,
  // needs localization
  /**
   * PERIOD
   */
  PERIOD: 190,
  // needs localization
  /**
   * SLASH
   */
  SLASH: 191,
  // needs localization
  /**
   * APOSTROPHE
   */
  APOSTROPHE: 192,
  // needs localization
  /**
   * SINGLE_QUOTE
   */
  SINGLE_QUOTE: 222,
  // needs localization
  /**
   * OPEN_SQUARE_BRACKET
   */
  OPEN_SQUARE_BRACKET: 219,
  // needs localization
  /**
   * BACKSLASH
   */
  BACKSLASH: 220,
  // needs localization
  /**
   * CLOSE_SQUARE_BRACKET
   */
  CLOSE_SQUARE_BRACKET: 221,
  // needs localization
  /**
   * WIN_KEY
   */
  WIN_KEY: 224,
  /**
   * MAC_FF_META
   */
  MAC_FF_META: 224,
  // Firefox (Gecko) fires this for the meta key instead of 91
  /**
   * WIN_IME
   */
  WIN_IME: 229,
  // ======================== Function ========================
  /**
   * whether text and modified key is entered at the same time.
   */
  isTextModifyingKeyEvent: function isTextModifyingKeyEvent(e) {
    var keyCode = e.keyCode;
    if (e.altKey && !e.ctrlKey || e.metaKey || // Function keys don't generate text
    keyCode >= KeyCode.F1 && keyCode <= KeyCode.F12) {
      return false;
    }
    switch (keyCode) {
      case KeyCode.ALT:
      case KeyCode.CAPS_LOCK:
      case KeyCode.CONTEXT_MENU:
      case KeyCode.CTRL:
      case KeyCode.DOWN:
      case KeyCode.END:
      case KeyCode.ESC:
      case KeyCode.HOME:
      case KeyCode.INSERT:
      case KeyCode.LEFT:
      case KeyCode.MAC_FF_META:
      case KeyCode.META:
      case KeyCode.NUMLOCK:
      case KeyCode.NUM_CENTER:
      case KeyCode.PAGE_DOWN:
      case KeyCode.PAGE_UP:
      case KeyCode.PAUSE:
      case KeyCode.PRINT_SCREEN:
      case KeyCode.RIGHT:
      case KeyCode.SHIFT:
      case KeyCode.UP:
      case KeyCode.WIN_KEY:
      case KeyCode.WIN_KEY_RIGHT:
        return false;
      default:
        return true;
    }
  },
  /**
   * whether character is entered.
   */
  isCharacterKey: function isCharacterKey(keyCode) {
    if (keyCode >= KeyCode.ZERO && keyCode <= KeyCode.NINE) {
      return true;
    }
    if (keyCode >= KeyCode.NUM_ZERO && keyCode <= KeyCode.NUM_MULTIPLY) {
      return true;
    }
    if (keyCode >= KeyCode.A && keyCode <= KeyCode.Z) {
      return true;
    }
    if (window.navigator.userAgent.indexOf("WebKit") !== -1 && keyCode === 0) {
      return true;
    }
    switch (keyCode) {
      case KeyCode.SPACE:
      case KeyCode.QUESTION_MARK:
      case KeyCode.NUM_PLUS:
      case KeyCode.NUM_MINUS:
      case KeyCode.NUM_PERIOD:
      case KeyCode.NUM_DIVISION:
      case KeyCode.SEMICOLON:
      case KeyCode.DASH:
      case KeyCode.EQUALS:
      case KeyCode.COMMA:
      case KeyCode.PERIOD:
      case KeyCode.SLASH:
      case KeyCode.APOSTROPHE:
      case KeyCode.SINGLE_QUOTE:
      case KeyCode.OPEN_SQUARE_BRACKET:
      case KeyCode.BACKSLASH:
      case KeyCode.CLOSE_SQUARE_BRACKET:
        return true;
      default:
        return false;
    }
  }
};
var Notify = /* @__PURE__ */ reactExports.forwardRef(function(props, ref) {
  var prefixCls = props.prefixCls, style = props.style, className = props.className, _props$duration = props.duration, duration = _props$duration === void 0 ? 4.5 : _props$duration, eventKey = props.eventKey, content2 = props.content, closable = props.closable, _props$closeIcon = props.closeIcon, closeIcon = _props$closeIcon === void 0 ? "x" : _props$closeIcon, divProps = props.props, onClick = props.onClick, onNoticeClose = props.onNoticeClose, times = props.times, forcedHovering = props.hovering;
  var _React$useState = reactExports.useState(false), _React$useState2 = _slicedToArray(_React$useState, 2), hovering = _React$useState2[0], setHovering = _React$useState2[1];
  var mergedHovering = forcedHovering || hovering;
  var onInternalClose = function onInternalClose2() {
    onNoticeClose(eventKey);
  };
  var onCloseKeyDown = function onCloseKeyDown2(e) {
    if (e.key === "Enter" || e.code === "Enter" || e.keyCode === KeyCode.ENTER) {
      onInternalClose();
    }
  };
  reactExports.useEffect(function() {
    if (!mergedHovering && duration > 0) {
      var timeout = setTimeout(function() {
        onInternalClose();
      }, duration * 1e3);
      return function() {
        clearTimeout(timeout);
      };
    }
  }, [duration, mergedHovering, times]);
  var noticePrefixCls = "".concat(prefixCls, "-notice");
  return /* @__PURE__ */ reactExports.createElement("div", _extends({}, divProps, {
    ref,
    className: classNames(noticePrefixCls, className, _defineProperty({}, "".concat(noticePrefixCls, "-closable"), closable)),
    style,
    onMouseEnter: function onMouseEnter(e) {
      var _divProps$onMouseEnte;
      setHovering(true);
      divProps === null || divProps === void 0 || (_divProps$onMouseEnte = divProps.onMouseEnter) === null || _divProps$onMouseEnte === void 0 || _divProps$onMouseEnte.call(divProps, e);
    },
    onMouseLeave: function onMouseLeave(e) {
      var _divProps$onMouseLeav;
      setHovering(false);
      divProps === null || divProps === void 0 || (_divProps$onMouseLeav = divProps.onMouseLeave) === null || _divProps$onMouseLeav === void 0 || _divProps$onMouseLeav.call(divProps, e);
    },
    onClick
  }), /* @__PURE__ */ reactExports.createElement("div", {
    className: "".concat(noticePrefixCls, "-content")
  }, content2), closable && /* @__PURE__ */ reactExports.createElement("a", {
    tabIndex: 0,
    className: "".concat(noticePrefixCls, "-close"),
    onKeyDown: onCloseKeyDown,
    onClick: function onClick2(e) {
      e.preventDefault();
      e.stopPropagation();
      onInternalClose();
    }
  }, closeIcon));
});
var NotificationContext = /* @__PURE__ */ React.createContext({});
var NotificationProvider = function NotificationProvider2(_ref) {
  var children = _ref.children, classNames2 = _ref.classNames;
  return /* @__PURE__ */ React.createElement(NotificationContext.Provider, {
    value: {
      classNames: classNames2
    }
  }, children);
};
var DEFAULT_OFFSET$1 = 8;
var DEFAULT_THRESHOLD = 3;
var DEFAULT_GAP = 16;
var useStack = function useStack2(config) {
  var result = {
    offset: DEFAULT_OFFSET$1,
    threshold: DEFAULT_THRESHOLD,
    gap: DEFAULT_GAP
  };
  if (config && _typeof(config) === "object") {
    var _config$offset, _config$threshold, _config$gap;
    result.offset = (_config$offset = config.offset) !== null && _config$offset !== void 0 ? _config$offset : DEFAULT_OFFSET$1;
    result.threshold = (_config$threshold = config.threshold) !== null && _config$threshold !== void 0 ? _config$threshold : DEFAULT_THRESHOLD;
    result.gap = (_config$gap = config.gap) !== null && _config$gap !== void 0 ? _config$gap : DEFAULT_GAP;
  }
  return [!!config, result];
};
var _excluded$1 = ["className", "style", "classNames", "styles"];
var NoticeList = function NoticeList2(props) {
  var _clsx;
  var configList = props.configList, placement = props.placement, prefixCls = props.prefixCls, className = props.className, style = props.style, motion = props.motion, onAllNoticeRemoved = props.onAllNoticeRemoved, onNoticeClose = props.onNoticeClose, stackConfig = props.stack;
  var _useContext = reactExports.useContext(NotificationContext), ctxCls = _useContext.classNames;
  var dictRef = reactExports.useRef({});
  var _useState = reactExports.useState(null), _useState2 = _slicedToArray(_useState, 2), latestNotice = _useState2[0], setLatestNotice = _useState2[1];
  var _useState3 = reactExports.useState([]), _useState4 = _slicedToArray(_useState3, 2), hoverKeys = _useState4[0], setHoverKeys = _useState4[1];
  var keys = configList.map(function(config) {
    return {
      config,
      key: String(config.key)
    };
  });
  var _useStack = useStack(stackConfig), _useStack2 = _slicedToArray(_useStack, 2), stack = _useStack2[0], _useStack2$ = _useStack2[1], offset = _useStack2$.offset, threshold = _useStack2$.threshold, gap = _useStack2$.gap;
  var expanded = stack && (hoverKeys.length > 0 || keys.length <= threshold);
  var placementMotion = typeof motion === "function" ? motion(placement) : motion;
  reactExports.useEffect(function() {
    if (stack && hoverKeys.length > 1) {
      setHoverKeys(function(prev) {
        return prev.filter(function(key) {
          return keys.some(function(_ref) {
            var dataKey = _ref.key;
            return key === dataKey;
          });
        });
      });
    }
  }, [hoverKeys, keys, stack]);
  reactExports.useEffect(function() {
    var _keys;
    if (stack && dictRef.current[(_keys = keys[keys.length - 1]) === null || _keys === void 0 ? void 0 : _keys.key]) {
      var _keys2;
      setLatestNotice(dictRef.current[(_keys2 = keys[keys.length - 1]) === null || _keys2 === void 0 ? void 0 : _keys2.key]);
    }
  }, [keys, stack]);
  return /* @__PURE__ */ React.createElement(CSSMotionList, _extends({
    key: placement,
    className: classNames(prefixCls, "".concat(prefixCls, "-").concat(placement), ctxCls === null || ctxCls === void 0 ? void 0 : ctxCls.list, className, (_clsx = {}, _defineProperty(_clsx, "".concat(prefixCls, "-stack"), !!stack), _defineProperty(_clsx, "".concat(prefixCls, "-stack-expanded"), expanded), _clsx)),
    style,
    keys,
    motionAppear: true
  }, placementMotion, {
    onAllRemoved: function onAllRemoved() {
      onAllNoticeRemoved(placement);
    }
  }), function(_ref2, nodeRef) {
    var config = _ref2.config, motionClassName = _ref2.className, motionStyle = _ref2.style, motionIndex = _ref2.index;
    var _ref3 = config, key = _ref3.key, times = _ref3.times;
    var strKey = String(key);
    var _ref4 = config, configClassName = _ref4.className, configStyle = _ref4.style, configClassNames = _ref4.classNames, configStyles = _ref4.styles, restConfig = _objectWithoutProperties(_ref4, _excluded$1);
    var dataIndex = keys.findIndex(function(item2) {
      return item2.key === strKey;
    });
    var stackStyle = {};
    if (stack) {
      var index = keys.length - 1 - (dataIndex > -1 ? dataIndex : motionIndex - 1);
      var transformX = placement === "top" || placement === "bottom" ? "-50%" : "0";
      if (index > 0) {
        var _dictRef$current$strK, _dictRef$current$strK2, _dictRef$current$strK3;
        stackStyle.height = expanded ? (_dictRef$current$strK = dictRef.current[strKey]) === null || _dictRef$current$strK === void 0 ? void 0 : _dictRef$current$strK.offsetHeight : latestNotice === null || latestNotice === void 0 ? void 0 : latestNotice.offsetHeight;
        var verticalOffset = 0;
        for (var i = 0; i < index; i++) {
          var _dictRef$current$keys;
          verticalOffset += ((_dictRef$current$keys = dictRef.current[keys[keys.length - 1 - i].key]) === null || _dictRef$current$keys === void 0 ? void 0 : _dictRef$current$keys.offsetHeight) + gap;
        }
        var transformY = (expanded ? verticalOffset : index * offset) * (placement.startsWith("top") ? 1 : -1);
        var scaleX = !expanded && latestNotice !== null && latestNotice !== void 0 && latestNotice.offsetWidth && (_dictRef$current$strK2 = dictRef.current[strKey]) !== null && _dictRef$current$strK2 !== void 0 && _dictRef$current$strK2.offsetWidth ? ((latestNotice === null || latestNotice === void 0 ? void 0 : latestNotice.offsetWidth) - offset * 2 * (index < 3 ? index : 3)) / ((_dictRef$current$strK3 = dictRef.current[strKey]) === null || _dictRef$current$strK3 === void 0 ? void 0 : _dictRef$current$strK3.offsetWidth) : 1;
        stackStyle.transform = "translate3d(".concat(transformX, ", ").concat(transformY, "px, 0) scaleX(").concat(scaleX, ")");
      } else {
        stackStyle.transform = "translate3d(".concat(transformX, ", 0, 0)");
      }
    }
    return /* @__PURE__ */ React.createElement("div", {
      ref: nodeRef,
      className: classNames("".concat(prefixCls, "-notice-wrapper"), motionClassName, configClassNames === null || configClassNames === void 0 ? void 0 : configClassNames.wrapper),
      style: _objectSpread2(_objectSpread2(_objectSpread2({}, motionStyle), stackStyle), configStyles === null || configStyles === void 0 ? void 0 : configStyles.wrapper),
      onMouseEnter: function onMouseEnter() {
        return setHoverKeys(function(prev) {
          return prev.includes(strKey) ? prev : [].concat(_toConsumableArray(prev), [strKey]);
        });
      },
      onMouseLeave: function onMouseLeave() {
        return setHoverKeys(function(prev) {
          return prev.filter(function(k) {
            return k !== strKey;
          });
        });
      }
    }, /* @__PURE__ */ React.createElement(Notify, _extends({}, restConfig, {
      ref: function ref(node) {
        if (dataIndex > -1) {
          dictRef.current[strKey] = node;
        } else {
          delete dictRef.current[strKey];
        }
      },
      prefixCls,
      classNames: configClassNames,
      styles: configStyles,
      className: classNames(configClassName, ctxCls === null || ctxCls === void 0 ? void 0 : ctxCls.notice),
      style: configStyle,
      times,
      key,
      eventKey: key,
      onNoticeClose,
      hovering: stack && hoverKeys.length > 0
    })));
  });
};
var Notifications = /* @__PURE__ */ reactExports.forwardRef(function(props, ref) {
  var _props$prefixCls = props.prefixCls, prefixCls = _props$prefixCls === void 0 ? "rc-notification" : _props$prefixCls, container = props.container, motion = props.motion, maxCount = props.maxCount, className = props.className, style = props.style, onAllRemoved = props.onAllRemoved, stack = props.stack, renderNotifications2 = props.renderNotifications;
  var _React$useState = reactExports.useState([]), _React$useState2 = _slicedToArray(_React$useState, 2), configList = _React$useState2[0], setConfigList = _React$useState2[1];
  var onNoticeClose = function onNoticeClose2(key) {
    var _config$onClose;
    var config = configList.find(function(item2) {
      return item2.key === key;
    });
    config === null || config === void 0 || (_config$onClose = config.onClose) === null || _config$onClose === void 0 || _config$onClose.call(config);
    setConfigList(function(list2) {
      return list2.filter(function(item2) {
        return item2.key !== key;
      });
    });
  };
  reactExports.useImperativeHandle(ref, function() {
    return {
      open: function open2(config) {
        setConfigList(function(list2) {
          var clone = _toConsumableArray(list2);
          var index = clone.findIndex(function(item2) {
            return item2.key === config.key;
          });
          var innerConfig = _objectSpread2({}, config);
          if (index >= 0) {
            var _list$index;
            innerConfig.times = (((_list$index = list2[index]) === null || _list$index === void 0 ? void 0 : _list$index.times) || 0) + 1;
            clone[index] = innerConfig;
          } else {
            innerConfig.times = 0;
            clone.push(innerConfig);
          }
          if (maxCount > 0 && clone.length > maxCount) {
            clone = clone.slice(-maxCount);
          }
          return clone;
        });
      },
      close: function close(key) {
        onNoticeClose(key);
      },
      destroy: function destroy2() {
        setConfigList([]);
      }
    };
  });
  var _React$useState3 = reactExports.useState({}), _React$useState4 = _slicedToArray(_React$useState3, 2), placements = _React$useState4[0], setPlacements = _React$useState4[1];
  reactExports.useEffect(function() {
    var nextPlacements = {};
    configList.forEach(function(config) {
      var _config$placement = config.placement, placement = _config$placement === void 0 ? "topRight" : _config$placement;
      if (placement) {
        nextPlacements[placement] = nextPlacements[placement] || [];
        nextPlacements[placement].push(config);
      }
    });
    Object.keys(placements).forEach(function(placement) {
      nextPlacements[placement] = nextPlacements[placement] || [];
    });
    setPlacements(nextPlacements);
  }, [configList]);
  var onAllNoticeRemoved = function onAllNoticeRemoved2(placement) {
    setPlacements(function(originPlacements) {
      var clone = _objectSpread2({}, originPlacements);
      var list2 = clone[placement] || [];
      if (!list2.length) {
        delete clone[placement];
      }
      return clone;
    });
  };
  var emptyRef = reactExports.useRef(false);
  reactExports.useEffect(function() {
    if (Object.keys(placements).length > 0) {
      emptyRef.current = true;
    } else if (emptyRef.current) {
      onAllRemoved === null || onAllRemoved === void 0 || onAllRemoved();
      emptyRef.current = false;
    }
  }, [placements]);
  if (!container) {
    return null;
  }
  var placementList = Object.keys(placements);
  return /* @__PURE__ */ reactDomExports.createPortal(/* @__PURE__ */ reactExports.createElement(reactExports.Fragment, null, placementList.map(function(placement) {
    var placementConfigList = placements[placement];
    var list2 = /* @__PURE__ */ reactExports.createElement(NoticeList, {
      key: placement,
      configList: placementConfigList,
      placement,
      prefixCls,
      className: className === null || className === void 0 ? void 0 : className(placement),
      style: style === null || style === void 0 ? void 0 : style(placement),
      motion,
      onNoticeClose,
      onAllNoticeRemoved,
      stack
    });
    return renderNotifications2 ? renderNotifications2(list2, {
      prefixCls,
      key: placement
    }) : list2;
  })), container);
});
var _excluded = ["getContainer", "motion", "prefixCls", "maxCount", "className", "style", "onAllRemoved", "stack", "renderNotifications"];
var defaultGetContainer = function defaultGetContainer2() {
  return document.body;
};
var uniqueKey = 0;
function mergeConfig() {
  var clone = {};
  for (var _len = arguments.length, objList = new Array(_len), _key = 0; _key < _len; _key++) {
    objList[_key] = arguments[_key];
  }
  objList.forEach(function(obj) {
    if (obj) {
      Object.keys(obj).forEach(function(key) {
        var val = obj[key];
        if (val !== void 0) {
          clone[key] = val;
        }
      });
    }
  });
  return clone;
}
function useNotification() {
  var rootConfig = arguments.length > 0 && arguments[0] !== void 0 ? arguments[0] : {};
  var _rootConfig$getContai = rootConfig.getContainer, getContainer = _rootConfig$getContai === void 0 ? defaultGetContainer : _rootConfig$getContai, motion = rootConfig.motion, prefixCls = rootConfig.prefixCls, maxCount = rootConfig.maxCount, className = rootConfig.className, style = rootConfig.style, onAllRemoved = rootConfig.onAllRemoved, stack = rootConfig.stack, renderNotifications2 = rootConfig.renderNotifications, shareConfig = _objectWithoutProperties(rootConfig, _excluded);
  var _React$useState = reactExports.useState(), _React$useState2 = _slicedToArray(_React$useState, 2), container = _React$useState2[0], setContainer = _React$useState2[1];
  var notificationsRef = reactExports.useRef();
  var contextHolder = /* @__PURE__ */ reactExports.createElement(Notifications, {
    container,
    ref: notificationsRef,
    prefixCls,
    motion,
    maxCount,
    className,
    style,
    onAllRemoved,
    stack,
    renderNotifications: renderNotifications2
  });
  var _React$useState3 = reactExports.useState([]), _React$useState4 = _slicedToArray(_React$useState3, 2), taskQueue2 = _React$useState4[0], setTaskQueue = _React$useState4[1];
  var api = reactExports.useMemo(function() {
    return {
      open: function open2(config) {
        var mergedConfig = mergeConfig(shareConfig, config);
        if (mergedConfig.key === null || mergedConfig.key === void 0) {
          mergedConfig.key = "rc-notification-".concat(uniqueKey);
          uniqueKey += 1;
        }
        setTaskQueue(function(queue) {
          return [].concat(_toConsumableArray(queue), [{
            type: "open",
            config: mergedConfig
          }]);
        });
      },
      close: function close(key) {
        setTaskQueue(function(queue) {
          return [].concat(_toConsumableArray(queue), [{
            type: "close",
            key
          }]);
        });
      },
      destroy: function destroy2() {
        setTaskQueue(function(queue) {
          return [].concat(_toConsumableArray(queue), [{
            type: "destroy"
          }]);
        });
      }
    };
  }, []);
  reactExports.useEffect(function() {
    setContainer(getContainer());
  });
  reactExports.useEffect(function() {
    if (notificationsRef.current && taskQueue2.length) {
      taskQueue2.forEach(function(task) {
        switch (task.type) {
          case "open":
            notificationsRef.current.open(task.config);
            break;
          case "close":
            notificationsRef.current.close(task.key);
            break;
          case "destroy":
            notificationsRef.current.destroy();
            break;
        }
      });
      setTaskQueue(function(oriQueue) {
        return oriQueue.filter(function(task) {
          return !taskQueue2.includes(task);
        });
      });
    }
  }, [taskQueue2]);
  return [api, contextHolder];
}
const genMessageStyle = (token) => {
  const {
    componentCls,
    iconCls,
    boxShadow,
    colorText,
    colorSuccess,
    colorError,
    colorWarning,
    colorInfo,
    fontSizeLG,
    motionEaseInOutCirc,
    motionDurationSlow,
    marginXS,
    paddingXS,
    borderRadiusLG,
    zIndexPopup,
    // Custom token
    contentPadding,
    contentBg
  } = token;
  const noticeCls = "".concat(componentCls, "-notice");
  const messageMoveIn = new Keyframe("MessageMoveIn", {
    "0%": {
      padding: 0,
      transform: "translateY(-100%)",
      opacity: 0
    },
    "100%": {
      padding: paddingXS,
      transform: "translateY(0)",
      opacity: 1
    }
  });
  const messageMoveOut = new Keyframe("MessageMoveOut", {
    "0%": {
      maxHeight: token.height,
      padding: paddingXS,
      opacity: 1
    },
    "100%": {
      maxHeight: 0,
      padding: 0,
      opacity: 0
    }
  });
  const noticeStyle = {
    padding: paddingXS,
    textAlign: "center",
    ["".concat(componentCls, "-custom-content > ").concat(iconCls)]: {
      verticalAlign: "text-bottom",
      marginInlineEnd: marginXS,
      // affected by ltr or rtl
      fontSize: fontSizeLG
    },
    ["".concat(noticeCls, "-content")]: {
      display: "inline-block",
      padding: contentPadding,
      background: contentBg,
      borderRadius: borderRadiusLG,
      boxShadow,
      pointerEvents: "all"
    },
    ["".concat(componentCls, "-success > ").concat(iconCls)]: {
      color: colorSuccess
    },
    ["".concat(componentCls, "-error > ").concat(iconCls)]: {
      color: colorError
    },
    ["".concat(componentCls, "-warning > ").concat(iconCls)]: {
      color: colorWarning
    },
    ["".concat(componentCls, "-info > ").concat(iconCls, ",\n      ").concat(componentCls, "-loading > ").concat(iconCls)]: {
      color: colorInfo
    }
  };
  return [
    // ============================ Holder ============================
    {
      [componentCls]: Object.assign(Object.assign({}, resetComponent(token)), {
        color: colorText,
        position: "fixed",
        top: marginXS,
        width: "100%",
        pointerEvents: "none",
        zIndex: zIndexPopup,
        ["".concat(componentCls, "-move-up")]: {
          animationFillMode: "forwards"
        },
        ["\n        ".concat(componentCls, "-move-up-appear,\n        ").concat(componentCls, "-move-up-enter\n      ")]: {
          animationName: messageMoveIn,
          animationDuration: motionDurationSlow,
          animationPlayState: "paused",
          animationTimingFunction: motionEaseInOutCirc
        },
        ["\n        ".concat(componentCls, "-move-up-appear").concat(componentCls, "-move-up-appear-active,\n        ").concat(componentCls, "-move-up-enter").concat(componentCls, "-move-up-enter-active\n      ")]: {
          animationPlayState: "running"
        },
        ["".concat(componentCls, "-move-up-leave")]: {
          animationName: messageMoveOut,
          animationDuration: motionDurationSlow,
          animationPlayState: "paused",
          animationTimingFunction: motionEaseInOutCirc
        },
        ["".concat(componentCls, "-move-up-leave").concat(componentCls, "-move-up-leave-active")]: {
          animationPlayState: "running"
        },
        "&-rtl": {
          direction: "rtl",
          span: {
            direction: "rtl"
          }
        }
      })
    },
    // ============================ Notice ============================
    {
      [componentCls]: {
        ["".concat(noticeCls, "-wrapper")]: Object.assign({}, noticeStyle)
      }
    },
    // ============================= Pure =============================
    {
      ["".concat(componentCls, "-notice-pure-panel")]: Object.assign(Object.assign({}, noticeStyle), {
        padding: 0,
        textAlign: "start"
      })
    }
  ];
};
const prepareComponentToken = (token) => ({
  zIndexPopup: token.zIndexPopupBase + CONTAINER_MAX_OFFSET + 10,
  contentBg: token.colorBgElevated,
  contentPadding: "".concat((token.controlHeightLG - token.fontSize * token.lineHeight) / 2, "px ").concat(token.paddingSM, "px")
});
const useStyle = genStyleHooks("Message", (token) => {
  const combinedToken = merge(token, {
    height: 150
  });
  return [genMessageStyle(combinedToken)];
}, prepareComponentToken);
var __rest$1 = function(s, e) {
  var t = {};
  for (var p in s)
    if (Object.prototype.hasOwnProperty.call(s, p) && e.indexOf(p) < 0)
      t[p] = s[p];
  if (s != null && typeof Object.getOwnPropertySymbols === "function")
    for (var i = 0, p = Object.getOwnPropertySymbols(s); i < p.length; i++) {
      if (e.indexOf(p[i]) < 0 && Object.prototype.propertyIsEnumerable.call(s, p[i]))
        t[p[i]] = s[p[i]];
    }
  return t;
};
const TypeIcon = {
  info: /* @__PURE__ */ reactExports.createElement(RefIcon, null),
  success: /* @__PURE__ */ reactExports.createElement(RefIcon$2, null),
  error: /* @__PURE__ */ reactExports.createElement(RefIcon$3, null),
  warning: /* @__PURE__ */ reactExports.createElement(RefIcon$1, null),
  loading: /* @__PURE__ */ reactExports.createElement(RefIcon$4, null)
};
const PureContent = (_ref) => {
  let {
    prefixCls,
    type,
    icon,
    children
  } = _ref;
  return /* @__PURE__ */ reactExports.createElement("div", {
    className: classNames("".concat(prefixCls, "-custom-content"), "".concat(prefixCls, "-").concat(type))
  }, icon || TypeIcon[type], /* @__PURE__ */ reactExports.createElement("span", null, children));
};
const PurePanel = (props) => {
  const {
    prefixCls: staticPrefixCls,
    className,
    type,
    icon,
    content: content2
  } = props, restProps = __rest$1(props, ["prefixCls", "className", "type", "icon", "content"]);
  const {
    getPrefixCls
  } = reactExports.useContext(ConfigContext);
  const prefixCls = staticPrefixCls || getPrefixCls("message");
  const rootCls = useCSSVarCls(prefixCls);
  const [wrapCSSVar, hashId, cssVarCls] = useStyle(prefixCls, rootCls);
  return wrapCSSVar(/* @__PURE__ */ reactExports.createElement(Notify, Object.assign({}, restProps, {
    prefixCls,
    className: classNames(className, hashId, "".concat(prefixCls, "-notice-pure-panel"), cssVarCls, rootCls),
    eventKey: "pure",
    duration: null,
    content: /* @__PURE__ */ reactExports.createElement(PureContent, {
      prefixCls,
      type,
      icon
    }, content2)
  })));
};
function getMotion(prefixCls, transitionName) {
  return {
    motionName: transitionName !== null && transitionName !== void 0 ? transitionName : "".concat(prefixCls, "-move-up")
  };
}
function wrapPromiseFn(openFn) {
  let closeFn;
  const closePromise = new Promise((resolve) => {
    closeFn = openFn(() => {
      resolve(true);
    });
  });
  const result = () => {
    closeFn === null || closeFn === void 0 ? void 0 : closeFn();
  };
  result.then = (filled, rejected) => closePromise.then(filled, rejected);
  result.promise = closePromise;
  return result;
}
var __rest = function(s, e) {
  var t = {};
  for (var p in s)
    if (Object.prototype.hasOwnProperty.call(s, p) && e.indexOf(p) < 0)
      t[p] = s[p];
  if (s != null && typeof Object.getOwnPropertySymbols === "function")
    for (var i = 0, p = Object.getOwnPropertySymbols(s); i < p.length; i++) {
      if (e.indexOf(p[i]) < 0 && Object.prototype.propertyIsEnumerable.call(s, p[i]))
        t[p[i]] = s[p[i]];
    }
  return t;
};
const DEFAULT_OFFSET = 8;
const DEFAULT_DURATION = 3;
const Wrapper = (_ref) => {
  let {
    children,
    prefixCls
  } = _ref;
  const rootCls = useCSSVarCls(prefixCls);
  const [wrapCSSVar, hashId, cssVarCls] = useStyle(prefixCls, rootCls);
  return wrapCSSVar(/* @__PURE__ */ reactExports.createElement(NotificationProvider, {
    classNames: {
      list: classNames(hashId, cssVarCls, rootCls)
    }
  }, children));
};
const renderNotifications = (node, _ref2) => {
  let {
    prefixCls,
    key
  } = _ref2;
  return /* @__PURE__ */ reactExports.createElement(Wrapper, {
    prefixCls,
    key
  }, node);
};
const Holder = /* @__PURE__ */ reactExports.forwardRef((props, ref) => {
  const {
    top: top2,
    prefixCls: staticPrefixCls,
    getContainer: staticGetContainer,
    maxCount,
    duration = DEFAULT_DURATION,
    rtl,
    transitionName,
    onAllRemoved
  } = props;
  const {
    getPrefixCls,
    getPopupContainer,
    message: message2,
    direction
  } = reactExports.useContext(ConfigContext);
  const prefixCls = staticPrefixCls || getPrefixCls("message");
  const getStyle = () => ({
    left: "50%",
    transform: "translateX(-50%)",
    top: top2 !== null && top2 !== void 0 ? top2 : DEFAULT_OFFSET
  });
  const getClassName = () => classNames({
    ["".concat(prefixCls, "-rtl")]: rtl !== null && rtl !== void 0 ? rtl : direction === "rtl"
  });
  const getNotificationMotion = () => getMotion(prefixCls, transitionName);
  const mergedCloseIcon = /* @__PURE__ */ reactExports.createElement("span", {
    className: "".concat(prefixCls, "-close-x")
  }, /* @__PURE__ */ reactExports.createElement(RefIcon$5, {
    className: "".concat(prefixCls, "-close-icon")
  }));
  const [api, holder] = useNotification({
    prefixCls,
    style: getStyle,
    className: getClassName,
    motion: getNotificationMotion,
    closable: false,
    closeIcon: mergedCloseIcon,
    duration,
    getContainer: () => (staticGetContainer === null || staticGetContainer === void 0 ? void 0 : staticGetContainer()) || (getPopupContainer === null || getPopupContainer === void 0 ? void 0 : getPopupContainer()) || document.body,
    maxCount,
    onAllRemoved,
    renderNotifications
  });
  reactExports.useImperativeHandle(ref, () => Object.assign(Object.assign({}, api), {
    prefixCls,
    message: message2
  }));
  return holder;
});
let keyIndex = 0;
function useInternalMessage(messageConfig) {
  const holderRef = reactExports.useRef(null);
  const wrapAPI = reactExports.useMemo(() => {
    const close = (key) => {
      var _a;
      (_a = holderRef.current) === null || _a === void 0 ? void 0 : _a.close(key);
    };
    const open2 = (config) => {
      if (!holderRef.current) {
        const fakeResult = () => {
        };
        fakeResult.then = () => {
        };
        return fakeResult;
      }
      const {
        open: originOpen,
        prefixCls,
        message: message2
      } = holderRef.current;
      const noticePrefixCls = "".concat(prefixCls, "-notice");
      const {
        content: content2,
        icon,
        type,
        key,
        className,
        style,
        onClose
      } = config, restConfig = __rest(config, ["content", "icon", "type", "key", "className", "style", "onClose"]);
      let mergedKey = key;
      if (mergedKey === void 0 || mergedKey === null) {
        keyIndex += 1;
        mergedKey = "antd-message-".concat(keyIndex);
      }
      return wrapPromiseFn((resolve) => {
        originOpen(Object.assign(Object.assign({}, restConfig), {
          key: mergedKey,
          content: /* @__PURE__ */ reactExports.createElement(PureContent, {
            prefixCls,
            type,
            icon
          }, content2),
          placement: "top",
          className: classNames(type && "".concat(noticePrefixCls, "-").concat(type), className, message2 === null || message2 === void 0 ? void 0 : message2.className),
          style: Object.assign(Object.assign({}, message2 === null || message2 === void 0 ? void 0 : message2.style), style),
          onClose: () => {
            onClose === null || onClose === void 0 ? void 0 : onClose();
            resolve();
          }
        }));
        return () => {
          close(mergedKey);
        };
      });
    };
    const destroy2 = (key) => {
      var _a;
      if (key !== void 0) {
        close(key);
      } else {
        (_a = holderRef.current) === null || _a === void 0 ? void 0 : _a.destroy();
      }
    };
    const clone = {
      open: open2,
      destroy: destroy2
    };
    const keys = ["info", "success", "warning", "error", "loading"];
    keys.forEach((type) => {
      const typeOpen2 = (jointContent, duration, onClose) => {
        let config;
        if (jointContent && typeof jointContent === "object" && "content" in jointContent) {
          config = jointContent;
        } else {
          config = {
            content: jointContent
          };
        }
        let mergedDuration;
        let mergedOnClose;
        if (typeof duration === "function") {
          mergedOnClose = duration;
        } else {
          mergedDuration = duration;
          mergedOnClose = onClose;
        }
        const mergedConfig = Object.assign(Object.assign({
          onClose: mergedOnClose,
          duration: mergedDuration
        }, config), {
          type
        });
        return open2(mergedConfig);
      };
      clone[type] = typeOpen2;
    });
    return clone;
  }, []);
  return [wrapAPI, /* @__PURE__ */ reactExports.createElement(Holder, Object.assign({
    key: "message-holder"
  }, messageConfig, {
    ref: holderRef
  }))];
}
function useMessage(messageConfig) {
  return useInternalMessage(messageConfig);
}
const AppConfigContext = /* @__PURE__ */ React.createContext({});
let message = null;
let act = (callback) => callback();
let taskQueue = [];
let defaultGlobalConfig = {};
function getGlobalContext() {
  const {
    getContainer,
    duration,
    rtl,
    maxCount,
    top: top2
  } = defaultGlobalConfig;
  const mergedContainer = (getContainer === null || getContainer === void 0 ? void 0 : getContainer()) || document.body;
  return {
    getContainer: () => mergedContainer,
    duration,
    rtl,
    maxCount,
    top: top2
  };
}
const GlobalHolder = /* @__PURE__ */ React.forwardRef((props, ref) => {
  const {
    messageConfig,
    sync
  } = props;
  const {
    getPrefixCls
  } = reactExports.useContext(ConfigContext);
  const prefixCls = defaultGlobalConfig.prefixCls || getPrefixCls("message");
  const appConfig = reactExports.useContext(AppConfigContext);
  const [api, holder] = useInternalMessage(Object.assign(Object.assign(Object.assign({}, messageConfig), {
    prefixCls
  }), appConfig.message));
  React.useImperativeHandle(ref, () => {
    const instance = Object.assign({}, api);
    Object.keys(instance).forEach((method) => {
      instance[method] = function() {
        sync();
        return api[method].apply(api, arguments);
      };
    });
    return {
      instance,
      sync
    };
  });
  return holder;
});
const GlobalHolderWrapper = /* @__PURE__ */ React.forwardRef((_, ref) => {
  const [messageConfig, setMessageConfig] = React.useState(getGlobalContext);
  const sync = () => {
    setMessageConfig(getGlobalContext);
  };
  React.useEffect(sync, []);
  const global = globalConfig();
  const rootPrefixCls = global.getRootPrefixCls();
  const rootIconPrefixCls = global.getIconPrefixCls();
  const theme = global.getTheme();
  const dom = /* @__PURE__ */ React.createElement(GlobalHolder, {
    ref,
    sync,
    messageConfig
  });
  return /* @__PURE__ */ React.createElement(ConfigProvider, {
    prefixCls: rootPrefixCls,
    iconPrefixCls: rootIconPrefixCls,
    theme
  }, global.holderRender ? global.holderRender(dom) : dom);
});
function flushNotice() {
  if (!message) {
    const holderFragment = document.createDocumentFragment();
    const newMessage = {
      fragment: holderFragment
    };
    message = newMessage;
    act(() => {
      render(/* @__PURE__ */ React.createElement(GlobalHolderWrapper, {
        ref: (node) => {
          const {
            instance,
            sync
          } = node || {};
          Promise.resolve().then(() => {
            if (!newMessage.instance && instance) {
              newMessage.instance = instance;
              newMessage.sync = sync;
              flushNotice();
            }
          });
        }
      }), holderFragment);
    });
    return;
  }
  if (!message.instance) {
    return;
  }
  taskQueue.forEach((task) => {
    const {
      type,
      skipped
    } = task;
    if (!skipped) {
      switch (type) {
        case "open": {
          act(() => {
            const closeFn = message.instance.open(Object.assign(Object.assign({}, defaultGlobalConfig), task.config));
            closeFn === null || closeFn === void 0 ? void 0 : closeFn.then(task.resolve);
            task.setCloseFn(closeFn);
          });
          break;
        }
        case "destroy":
          act(() => {
            message === null || message === void 0 ? void 0 : message.instance.destroy(task.key);
          });
          break;
        default: {
          act(() => {
            var _message$instance;
            const closeFn = (_message$instance = message.instance)[type].apply(_message$instance, _toConsumableArray(task.args));
            closeFn === null || closeFn === void 0 ? void 0 : closeFn.then(task.resolve);
            task.setCloseFn(closeFn);
          });
        }
      }
    }
  });
  taskQueue = [];
}
function setMessageGlobalConfig(config) {
  defaultGlobalConfig = Object.assign(Object.assign({}, defaultGlobalConfig), config);
  act(() => {
    var _a;
    (_a = message === null || message === void 0 ? void 0 : message.sync) === null || _a === void 0 ? void 0 : _a.call(message);
  });
}
function open(config) {
  const result = wrapPromiseFn((resolve) => {
    let closeFn;
    const task = {
      type: "open",
      config,
      resolve,
      setCloseFn: (fn) => {
        closeFn = fn;
      }
    };
    taskQueue.push(task);
    return () => {
      if (closeFn) {
        act(() => {
          closeFn();
        });
      } else {
        task.skipped = true;
      }
    };
  });
  flushNotice();
  return result;
}
function typeOpen(type, args) {
  const result = wrapPromiseFn((resolve) => {
    let closeFn;
    const task = {
      type,
      args,
      resolve,
      setCloseFn: (fn) => {
        closeFn = fn;
      }
    };
    taskQueue.push(task);
    return () => {
      if (closeFn) {
        act(() => {
          closeFn();
        });
      } else {
        task.skipped = true;
      }
    };
  });
  flushNotice();
  return result;
}
function destroy(key) {
  taskQueue.push({
    type: "destroy",
    key
  });
  flushNotice();
}
const methods = ["success", "info", "warning", "error", "loading"];
const baseStaticMethods = {
  open,
  destroy,
  config: setMessageGlobalConfig,
  useMessage,
  _InternalPanelDoNotUseOrYouWillBeFired: PurePanel
};
const staticMethods = baseStaticMethods;
methods.forEach((type) => {
  staticMethods[type] = function() {
    for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
      args[_key] = arguments[_key];
    }
    return typeOpen(type, args);
  };
});
const svg_theme_fill_color$6 = "_svg_theme_fill_color_2zggz_3";
const uploadContainer = "_uploadContainer_2zggz_55";
const fileInput = "_fileInput_2zggz_62";
const uploadButton = "_uploadButton_2zggz_66";
const item = "_item_2zggz_145";
const top = "_top_2zggz_149";
const botton = "_botton_2zggz_333";
const uploadButton2 = "_uploadButton2_2zggz_518";
const progressBar = "_progressBar_2zggz_614";
const statusMessage = "_statusMessage_2zggz_620";
const successMessage = "_successMessage_2zggz_625";
const errorMessage = "_errorMessage_2zggz_629";
const uploadImg = "_uploadImg_2zggz_633";
const tips$1 = "_tips_2zggz_645";
const css$6 = {
  svg_theme_fill_color: svg_theme_fill_color$6,
  uploadContainer,
  fileInput,
  uploadButton,
  item,
  top,
  botton,
  uploadButton2,
  progressBar,
  statusMessage,
  successMessage,
  errorMessage,
  uploadImg,
  tips: tips$1
};
const Upload = () => {
  reactExports.useState(null);
  reactExports.useState(0);
  const [uploadStatus, setUploadStatus] = reactExports.useState("");
  const [uploadResult, setUploadResult] = reactExports.useState(null);
  const handleFileChange = (event) => {
    setUploadStatus("ready");
    uploadFileFn(event.target.files[0]);
  };
  reactExports.useEffect(() => {
    events.on("closeUpload", handleEvent);
    return () => {
      events.off("closeUpload", handleEvent);
    };
  }, []);
  const handleEvent = () => {
    setUploadResult(null);
    setUploadStatus("");
  };
  async function uploadFileFn(file) {
    console.log("file :>> ", file);
    if (file.size / 1024 / 1024 > 50) {
      Message$1.error(
        trans("The file size cannot exceed {{size}}", { size: "50MB" })
      );
      return;
    }
    if (!file || uploadStatus == "loading")
      return;
    setUploadStatus("loading");
    try {
      const response = await S3PutObject(file);
      setUploadResult(response);
      events.emit("uploadSuccess", response);
      setUploadStatus("success");
    } catch (e) {
      console.error(e);
      setUploadStatus("error");
    }
  }
  const videoRef = reactExports.useRef(null);
  const handleVideoClick = () => {
    if (videoRef.current) {
      if (videoRef.current.paused) {
        videoRef.current.play();
      } else {
        videoRef.current.pause();
      }
    }
  };
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { children: [
    uploadResult && /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$6.uploadImg, children: uploadStatus == "loading" ? /* @__PURE__ */ jsxRuntimeExports.jsx(Spin, {}) : /* @__PURE__ */ jsxRuntimeExports.jsx(jsxRuntimeExports.Fragment, { children: uploadResult.type.includes("video") ? /* @__PURE__ */ jsxRuntimeExports.jsx(
      "video",
      {
        onClick: handleVideoClick,
        ref: videoRef,
        style: { width: "100rem", height: "100rem" },
        children: /* @__PURE__ */ jsxRuntimeExports.jsx(
          "source",
          {
            src: "".concat(window.location.origin).concat(uploadResult.fullPath),
            type: "video/mp4"
          }
        )
      }
    ) : /* @__PURE__ */ jsxRuntimeExports.jsx("img", { src: "".concat(window.location.origin).concat(uploadResult.fullPath) }) }) }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: joinClass(css$6.uploadContainer, "button"), children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx(
        "input",
        {
          type: "file",
          onChange: handleFileChange,
          accept: "image/*, video/*",
          id: "fileInput",
          className: css$6.fileInput
        }
      ),
      !uploadResult ? /* @__PURE__ */ jsxRuntimeExports.jsx("label", { htmlFor: "fileInput", className: css$6.uploadButton, children: uploadStatus == "loading" ? /* @__PURE__ */ jsxRuntimeExports.jsx(Spin, {}) : /* @__PURE__ */ jsxRuntimeExports.jsxs(jsxRuntimeExports.Fragment, { children: [
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$6.top, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$6.item }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$6.item })
        ] }),
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$6.botton, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$6.item }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$6.item })
        ] })
      ] }) }) : /* @__PURE__ */ jsxRuntimeExports.jsx("label", { htmlFor: "fileInput", style: { display: "flex" }, children: /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: css$6.uploadButton2, children: trans("Resend") }) })
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$6.tips, children: trans("The file size cannot exceed {{size}}", { size: "50MB" }) })
  ] });
};
const svg_theme_fill_color$5 = "_svg_theme_fill_color_yne6e_3";
const messageBox$1 = "_messageBox_yne6e_55";
const contentBox$4 = "_contentBox_yne6e_76";
const inSetBox = "_inSetBox_yne6e_81";
const showNotice = "_showNotice_yne6e_88";
const showMessage = "_showMessage_yne6e_91";
const showFeedback = "_showFeedback_yne6e_94";
const css$5 = {
  svg_theme_fill_color: svg_theme_fill_color$5,
  messageBox: messageBox$1,
  contentBox: contentBox$4,
  inSetBox,
  showNotice,
  showMessage,
  showFeedback
};
const svg_theme_fill_color$4 = "_svg_theme_fill_color_yc93y_3";
const headerBox = "_headerBox_yc93y_55";
const leftBox$2 = "_leftBox_yc93y_144";
const backArrowBox = "_backArrowBox_yc93y_150";
const ico = "_ico_yc93y_161";
const tabsBox = "_tabsBox_yc93y_220";
const active$1 = "_active_yc93y_285";
const numBox = "_numBox_yc93y_378";
const rightBox$2 = "_rightBox_yc93y_393";
const editBox = "_editBox_yc93y_481";
const selectAll = "_selectAll_yc93y_487";
const cancel = "_cancel_yc93y_489";
const noCheck$1 = "_noCheck_yc93y_624";
const css$4 = {
  svg_theme_fill_color: svg_theme_fill_color$4,
  headerBox,
  leftBox: leftBox$2,
  backArrowBox,
  ico,
  tabsBox,
  active: active$1,
  numBox,
  rightBox: rightBox$2,
  editBox,
  selectAll,
  "delete": "_delete_yc93y_488",
  cancel,
  noCheck: noCheck$1
};
const Header = ({
  type,
  isEdit,
  selectList,
  messageList,
  onSelectAll,
  onDeleteMessage,
  onSelectType = () => {
  },
  updateIsEdit
}) => {
  const navigate = useNavigate();
  const { num: num2 } = useMessageStore();
  useUserInfoStore();
  const { t, i18n } = useTranslation();
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$4.headerBox, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$4.leftBox, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx(
        "div",
        {
          className: css$4.backArrowBox,
          onClick: () => {
            navigate(-1);
          },
          children: /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$4.ico, children: /* @__PURE__ */ jsxRuntimeExports.jsx(ArrowLeftInMineIcon, {}) })
        }
      ),
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$4.tabsBox, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          "div",
          {
            className: type === "service" ? css$4.active : "",
            onClick: () => {
              onSelectType("service");
            },
            children: t("现在联系")
          }
        ),
        /* @__PURE__ */ jsxRuntimeExports.jsxs(
          "div",
          {
            className: type === "message" ? css$4.active : "",
            onClick: () => {
              onSelectType("message");
            },
            children: [
              t("消息"),
              num2 ? /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$4.numBox, children: num2 }) : null
            ]
          }
        ),
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          "div",
          {
            className: type === "notice" ? css$4.active : "",
            onClick: () => {
              onSelectType("notice");
            },
            children: t("通知")
          }
        ),
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          "div",
          {
            className: type === "feedback" ? css$4.active : "",
            onClick: () => {
              onSelectType("feedback");
            },
            children: t("Suggestion Bonus")
          }
        )
      ] })
    ] }),
    type === "message" ? /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$4.rightBox, children: isEdit ? /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$4.editBox, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$4.selectAll, onClick: () => onSelectAll(), children: [
        selectList.length === messageList.length ? /* @__PURE__ */ jsxRuntimeExports.jsx(SelectIcon, {}) : /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$4.noCheck }),
        /* @__PURE__ */ jsxRuntimeExports.jsx("span", { children: t("全选") })
      ] }),
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$4.delete, onClick: () => onDeleteMessage(), children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx(DeleteIcon, { className: css$4.icon }),
        /* @__PURE__ */ jsxRuntimeExports.jsx("span", { children: t("删除") })
      ] }),
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$4.cancel, onClick: () => updateIsEdit(false), children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx(InputClearIcon, {}),
        /* @__PURE__ */ jsxRuntimeExports.jsx("span", { children: t("取消") })
      ] })
    ] }) : /* @__PURE__ */ jsxRuntimeExports.jsx(jsxRuntimeExports.Fragment, { children: /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$4.selectAll, onClick: () => updateIsEdit(true), children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx(MessageSetIcon, { className: css$4.icon }),
      /* @__PURE__ */ jsxRuntimeExports.jsx("span", { children: t("管理") })
    ] }) }) }) : null
  ] });
};
const svg_theme_fill_color$3 = "_svg_theme_fill_color_1tp6j_3";
const messageBox = "_messageBox_1tp6j_55";
const contentBox$3 = "_contentBox_1tp6j_59";
const itemBox$1 = "_itemBox_1tp6j_65";
const alreadySelect = "_alreadySelect_1tp6j_160";
const leftBox$1 = "_leftBox_1tp6j_223";
const iconBox$1 = "_iconBox_1tp6j_228";
const readSpan = "_readSpan_1tp6j_235";
const noMargin = "_noMargin_1tp6j_249";
const noCheck = "_noCheck_1tp6j_252";
const selectIcon = "_selectIcon_1tp6j_348";
const infoBox$1 = "_infoBox_1tp6j_484";
const title$3 = "_title_1tp6j_489";
const time$1 = "_time_1tp6j_546";
const readInfoBox = "_readInfoBox_1tp6j_619";
const rightBox$1 = "_rightBox_1tp6j_667";
const text$2 = "_text_1tp6j_672";
const arrowIcon$2 = "_arrowIcon_1tp6j_677";
const is_read = "_is_read_1tp6j_733";
const css$3 = {
  svg_theme_fill_color: svg_theme_fill_color$3,
  messageBox,
  contentBox: contentBox$3,
  itemBox: itemBox$1,
  alreadySelect,
  leftBox: leftBox$1,
  iconBox: iconBox$1,
  readSpan,
  noMargin,
  noCheck,
  selectIcon,
  infoBox: infoBox$1,
  title: title$3,
  time: time$1,
  readInfoBox,
  rightBox: rightBox$1,
  text: text$2,
  arrowIcon: arrowIcon$2,
  is_read
};
const listMaps = {
  black: "/message/no_read_message_icon_black.webp",
  blue: "/message/no_read_message_icon_blue.webp",
  whiteGreen: "/message/no_read_message_icon_white_green.webp",
  purple: "/message/no_read_message_icon_purple.webp",
  oilyGreen: "/message/no_read_message_icon_oilyGreen.webp",
  whiteRed: "/message/no_read_message_icon_whiteRed.webp",
  versaceYellow: "/message/no_read_message_icon_versaceYellow.webp",
  lancomePeach: "/message/no_read_message_icon_lancomePeach.webp",
  hermesOrange: "/message/no_read_message_icon_hermes_orange.webp",
  whiteBlue: "/message/no_read_message_icon_whiteBlue.webp",
  whiteYellow: "/message/no_read_message_icon_whiteYellow.webp",
  lightBrown: "/message/no_read_message_icon_lightBrown.webp",
  whiteOrange: "/message/no_read_message_icon_whiteOrange.webp",
  furlaBlue: "/message/no_read_message_icon_furlaBlue.webp",
  whitePink: "/message/no_read_message_icon_whitePink.webp",
  bvGreen: "/message/no_read_message_icon_bvGreen.webp",
  whiteBrown: "/message/no_read_message_icon_whiteBrown.webp",
  AnnaSuiPurple: "/message/no_read_message_icon_AnnaSuiPurple.webp",
  whitePurple: "/message/no_read_message_icon_whitePurple.webp",
  whiteDarkGreen: "/message/no_read_message_icon_whiteDarkGreen.webp",
  burgundyRed: "/message/no_read_message_icon_burgundyRe.webp",
  sk2: "/message/no_read_message_icon_sk2.webp",
  greenGold: "/message/no_read_message_icon_greenGold.webp"
};
const listReadMaps = {
  black: "/message/read_message_icon_black.webp",
  blue: "/message/read_message_icon_blue.webp",
  whiteGreen: "/message/read_message_icon_whiteGreen.webp",
  purple: "/message/read_message_icon_purple.webp",
  oilyGreen: "/message/read_message_icon_oilyGreen.webp",
  whiteRed: "/message/read_message_icon_whiteRed.webp",
  versaceYellow: "/message/read_message_icon_versaceYellow.webp",
  lancomePeach: "/message/read_message_icon_lancomePeach.webp",
  hermesOrange: "/message/read_message_icon_hermes_orange.webp",
  whiteBlue: "/message/read_message_icon_whiteBlue.webp",
  whiteYellow: "/message/read_message_icon_whiteYellow.webp",
  lightBrown: "/message/read_message_icon_lightBrown.webp",
  whiteOrange: "/message/read_message_icon_whiteOrange.webp",
  furlaBlue: "/message/read_message_icon_furlaBlue.webp",
  whitePink: "/message/read_message_icon_whitePink.webp",
  bvGreen: "/message/read_message_icon_bvGreen.webp",
  whiteBrown: "/message/read_message_icon_whiteBrown.webp",
  AnnaSuiPurple: "/message/read_message_icon_AnnaSuiPurple.webp",
  whitePurple: "/message/read_message_icon_whitePurple.webp",
  whiteDarkGreen: "/message/read_message_icon_whiteDarkGreen.webp",
  burgundyRed: "/message/read_message_icon_burgundyRed.webp",
  sk2: "/message/read_message_icon_sk2.webp",
  greenGold: "/message/read_message_icon_greenGold.webp"
};
const MessageBox = ({
  messageList,
  isEdit,
  children,
  selectList = [],
  onSelect
}) => {
  const { getMessageNumBySotre } = useMessageStore((state) => state);
  const { theme } = useUserInfoStore();
  const navigate = useNavigate();
  return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$3.messageBox, children: /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$3.contentBox, children: [
    messageList.length === 0 ? /* @__PURE__ */ jsxRuntimeExports.jsx(Empty, {}) : messageList.map((message2, idx) => {
      const isSelect = selectList.indexOf(message2.id) > -1;
      return /* @__PURE__ */ jsxRuntimeExports.jsxs(
        "div",
        {
          className: joinClass(
            css$3.itemBox,
            isSelect && isEdit ? css$3.alreadySelect : "",
            message2.is_read === 0 ? css$3.is_read : ""
          ),
          onClick: async () => {
            if (isEdit) {
              onSelect(message2.id);
              return;
            }
            Cache.set("messageDetail", {
              ...message2,
              page_type: "message"
            });
            navigate("/messageDetail");
            if (message2.is_read === 0) {
              await readUserMessage({ id: message2.id });
              getMessageNumBySotre();
            }
          },
          children: [
            /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$3.leftBox, children: [
              isEdit ? /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: joinClass(css$3.iconBox, css$3.noMargin), children: isSelect ? /* @__PURE__ */ jsxRuntimeExports.jsx(SelectIcon, { className: css$3.selectIcon }) : /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$3.noCheck }) }) : null,
              /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$3.iconBox, children: message2.is_read === 0 ? /* @__PURE__ */ jsxRuntimeExports.jsx(
                Image,
                {
                  src: listMaps[theme] || "/message/no_read_message_icon.webp"
                }
              ) : /* @__PURE__ */ jsxRuntimeExports.jsx(
                Image,
                {
                  src: listReadMaps[theme] || listMaps[theme] || "/message/no_read_message_icon.webp"
                }
              ) }),
              /* @__PURE__ */ jsxRuntimeExports.jsxs(
                "div",
                {
                  className: "".concat(css$3.infoBox, " ").concat(message2.is_read === 0 ? "" : css$3.readInfoBox),
                  children: [
                    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$3.title, children: message2.title }),
                    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$3.time, children: customFormatTimer(message2.send_at) })
                  ]
                }
              )
            ] }),
            /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$3.rightBox, children: /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$3.arrowIcon, children: /* @__PURE__ */ jsxRuntimeExports.jsx(ArrowLeftInMineIcon, {}) }) })
          ]
        },
        idx
      );
    }),
    children
  ] }) });
};
const svg_theme_fill_color$2 = "_svg_theme_fill_color_1uxax_3";
const noticeBox = "_noticeBox_1uxax_55";
const contentBox$2 = "_contentBox_1uxax_59";
const itemBox = "_itemBox_1uxax_64";
const leftBox = "_leftBox_1uxax_154";
const iconBox = "_iconBox_1uxax_159";
const infoBox = "_infoBox_1uxax_291";
const title$2 = "_title_1uxax_298";
const time = "_time_1uxax_362";
const rightBox = "_rightBox_1uxax_434";
const text$1 = "_text_1uxax_439";
const arrowIcon$1 = "_arrowIcon_1uxax_444";
const css$2 = {
  svg_theme_fill_color: svg_theme_fill_color$2,
  noticeBox,
  contentBox: contentBox$2,
  itemBox,
  leftBox,
  iconBox,
  infoBox,
  title: title$2,
  time,
  rightBox,
  text: text$1,
  arrowIcon: arrowIcon$1
};
const NoticeBox = ({ type }) => {
  const navigate = useNavigate();
  useUserInfoStore();
  const state = useReactive({
    list: []
  });
  useAsyncEffect(async () => {
    if (type !== "notice")
      return;
    const [res] = await getNoticeList();
    if (res && Array.isArray(res) && res.length > 0) {
      state.list = res;
    }
  }, [type]);
  const { list: list2 } = state;
  return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.noticeBox, children: /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.contentBox, children: list2.length === 0 ? /* @__PURE__ */ jsxRuntimeExports.jsx(Empty, {}) : list2.map((message2, idx) => {
    return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$2.itemBox, onClick: async () => {
      Cache.set("messageDetail", { ...message2, page_type: "notice" });
      navigate("/messageDetail");
    }, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$2.leftBox, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.iconBox, children: /* @__PURE__ */ jsxRuntimeExports.jsx(MessageVolumIcon, {}) }),
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$2.infoBox, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.title, children: message2.title }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.time, children: customFormatTimer(message2.created_at) })
        ] })
      ] }),
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.rightBox, children: /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$2.arrowIcon, children: /* @__PURE__ */ jsxRuntimeExports.jsx(ArrowLeftInMineIcon, {}) }) })
    ] }, idx);
  }) }) });
};
const svg_theme_fill_color$1 = "_svg_theme_fill_color_8uf9v_3";
const feedback = "_feedback_8uf9v_55";
const header = "_header_8uf9v_59";
const left$1 = "_left_8uf9v_65";
const btn$1 = "_btn_8uf9v_69";
const active = "_active_8uf9v_174";
const right$1 = "_right_8uf9v_288";
const monye = "_monye_8uf9v_292";
const pendente = "_pendente_8uf9v_297";
const num = "_num_8uf9v_369";
const btns = "_btns_8uf9v_441";
const btns2 = "_btns2_8uf9v_455";
const contentBox$1 = "_contentBox_8uf9v_547";
const add = "_add_8uf9v_554";
const title$1 = "_title_8uf9v_628";
const contentTxt = "_contentTxt_8uf9v_767";
const numTxt = "_numTxt_8uf9v_959";
const imgHead = "_imgHead_8uf9v_1031";
const footHead = "_footHead_8uf9v_1172";
const tips = "_tips_8uf9v_1222";
const btnBottn = "_btnBottn_8uf9v_1295";
const listBox = "_listBox_8uf9v_1466";
const list = "_list_8uf9v_1466";
const listHead = "_listHead_8uf9v_1566";
const id = "_id_8uf9v_1575";
const copyIcon = "_copyIcon_8uf9v_1605";
const arrowIcon = "_arrowIcon_8uf9v_1748";
const listContent = "_listContent_8uf9v_1815";
const updateTime = "_updateTime_8uf9v_1818";
const listText = "_listText_8uf9v_1823";
const detailImg = "_detailImg_8uf9v_1829";
const detailTime = "_detailTime_8uf9v_1840";
const detailContent = "_detailContent_8uf9v_1993";
const text = "_text_8uf9v_1998";
const line = "_line_8uf9v_2091";
const updatedAt = "_updatedAt_8uf9v_2139";
const replyContent = "_replyContent_8uf9v_2265";
const css$1 = {
  svg_theme_fill_color: svg_theme_fill_color$1,
  feedback,
  header,
  left: left$1,
  btn: btn$1,
  active,
  right: right$1,
  monye,
  pendente,
  num,
  btns,
  btns2,
  contentBox: contentBox$1,
  add,
  title: title$1,
  contentTxt,
  numTxt,
  imgHead,
  footHead,
  tips,
  btnBottn,
  listBox,
  list,
  listHead,
  id,
  copyIcon,
  arrowIcon,
  listContent,
  updateTime,
  listText,
  detailImg,
  detailTime,
  detailContent,
  text,
  line,
  updatedAt,
  replyContent
};
const Feedback = ({ type }) => {
  useNavigate();
  const { t, i18n } = useTranslation();
  const { theme, info } = useUserInfoStore();
  const state = useReactive({
    list: [],
    btnTpye: 1,
    text: "",
    attachment_url: "",
    attachment_type: "",
    detailType: false,
    //详情类型
    itemDetail: {},
    //详情数据
    amount: 0,
    page: 1,
    totle: 0
  });
  const withdraw = async (id2) => {
    const [res] = await withdrawFeedback({ uid: info.uid });
    if (res == 1e3) {
      staticMethods.success(t("领取成功"));
      state.amount = 0;
    }
  };
  const handleScroll = () => {
    if (state.list.length < state.totle) {
      state.page++;
    }
  };
  const feedbackList = async () => {
    if (!info)
      return;
    let params = {
      uid: info.uid,
      //		用户id(必选)
      page: state.page,
      page_size: 10
    };
    const [res] = await listFeedback(params);
    if (res) {
      state.list = [...state.list, ...res.d || []];
      if (state.page == 1) {
        state.amount = res.a || 0;
        state.totle = res.t || 0;
      }
    }
  };
  reactExports.useEffect(() => {
    if (state.btnTpye == 2) {
      feedbackList();
    }
  }, [state.page]);
  const { list: list2, btnTpye, text: text2, detailType, itemDetail } = state;
  const maxLength = 500;
  const handleChange = (event) => {
    state.text = event.target.value;
  };
  const btnSbumit = async () => {
    let params = {
      uid: info.uid,
      //		用户id(必选)
      username: info.username,
      //		用户名称(必选)
      content: state.text,
      //		string		反馈内容(必选)
      attachment_url: state.attachment_url,
      //	string		上传附件(可选)
      attachment_type: state.attachment_type
      //	string		附件类型(可选) 1:图片 2:视频
      // currency: "", //	string		货币类型(可选)
    };
    if (params.content.trim() == "") {
      return staticMethods.error(t("Feedback cannot be empty"));
    }
    const [res] = await addFeedback(params);
    if (res == 1e3) {
      staticMethods.success(t("Thank you for your valuable feedback"));
      state.text = "";
      state.attachment_url = "";
      state.attachment_type = "";
      events.emit("closeUpload");
    }
  };
  reactExports.useEffect(() => {
    events.on("uploadSuccess", handleEvent);
    return () => {
      events.off("uploadSuccess", handleEvent);
    };
  }, []);
  const handleEvent = (data) => {
    if (data.type.includes("video")) {
      state.attachment_type = "2";
    } else {
      state.attachment_type = "1";
    }
    state.attachment_url = data.fullPath;
  };
  const btnDetail = (item2) => {
    state.detailType = true;
    state.itemDetail = item2;
  };
  const videoRef = reactExports.useRef(null);
  const handleVideoClick = () => {
    if (videoRef.current) {
      if (videoRef.current.paused) {
        videoRef.current.play();
      } else {
        videoRef.current.pause();
      }
    }
  };
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.feedback, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.header, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.left, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsxs(
          "div",
          {
            className: joinClass(css$1.btn, btnTpye == 1 ? css$1.active : ""),
            onClick: () => {
              state.btnTpye = 1;
            },
            children: [
              /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: t("Create") }),
              /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: t("feedback") })
            ]
          }
        ),
        /* @__PURE__ */ jsxRuntimeExports.jsxs(
          "div",
          {
            className: joinClass(css$1.btn, btnTpye == 2 ? css$1.active : ""),
            onClick: () => {
              state.page = 1;
              state.list = [];
              state.btnTpye = 2;
              state.detailType = false;
              feedbackList();
            },
            children: [
              /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: t("My") }),
              /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: t("feedback") })
            ]
          }
        )
      ] }),
      btnTpye == 2 ? /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.right, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.monye, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$1.pendente, children: t("Reward") }),
          /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.num, children: [
            state.amount,
            " "
          ] })
        ] }),
        /* @__PURE__ */ jsxRuntimeExports.jsxs(
          "div",
          {
            onClick: () => {
              if (state.amount != 0)
                withdraw();
            },
            className: joinClass(
              state.amount != 0 ? css$1.btns2 : "",
              css$1.btns
            ),
            children: [
              /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: t("Claimi") }),
              /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: t("全部1") })
            ]
          }
        )
      ] }) : /* @__PURE__ */ jsxRuntimeExports.jsx("div", {})
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$1.contentBox, children: btnTpye == 1 ? /* @__PURE__ */ jsxRuntimeExports.jsxs(jsxRuntimeExports.Fragment, { children: [
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.add, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.title, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("span", { children: t("Feed Content") }),
          /* @__PURE__ */ jsxRuntimeExports.jsxs("span", { children: [
            " (",
            t("Suggestions for revision"),
            ")"
          ] })
        ] }),
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.contentTxt, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx(
            "textarea",
            {
              value: text2,
              onChange: handleChange,
              placeholder: t(
                "Your opinions are valuable to us. All valuable opinions will be accepted, and once accepted, will be rewarded with cash prizes according to their usefulness. We welcome your opinions!"
              ),
              maxLength
            }
          ),
          /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.numTxt, children: [
            /* @__PURE__ */ jsxRuntimeExports.jsx("span", { children: text2.length }),
            "/",
            maxLength
          ] })
        ] }),
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.imgHead, children: [
          t("Pictures don't lie"),
          /* @__PURE__ */ jsxRuntimeExports.jsxs("span", { children: [
            "(",
            t("Easier to be adopted"),
            ")"
          ] })
        ] }),
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: /* @__PURE__ */ jsxRuntimeExports.jsx(Upload, {}) }),
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$1.footHead, children: t("Reward Rules") }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$1.tips, children: t(
            "We've set up huge bonuses specifically to collect feedback so that we can optimize the system and features to give you a better experience! Once accepted, rewards will be given based on the usefulness (except those not accepted)"
          ) })
        ] })
      ] }),
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$1.btnBottn, children: /* @__PURE__ */ jsxRuntimeExports.jsx(
        "div",
        {
          className: joinClass(css$1.btns, "button"),
          onClick: () => {
            btnSbumit();
          },
          children: t("Submit Feedback")
        }
      ) })
    ] }) : list2.length === 0 ? /* @__PURE__ */ jsxRuntimeExports.jsx(Empty, {}) : /* @__PURE__ */ jsxRuntimeExports.jsx(jsxRuntimeExports.Fragment, { children: /* @__PURE__ */ jsxRuntimeExports.jsx(
      "div",
      {
        className: css$1.listBox,
        onScroll: (event) => {
          const { scrollHeight, scrollTop, clientHeight } = event.currentTarget;
          if (scrollHeight - scrollTop === clientHeight) {
            handleScroll();
            console.log("已经滚动到底部");
          }
        },
        children: !detailType ? list2.map((item2, index) => {
          return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.list, children: [
            /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.listHead, children: [
              /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.left, children: [
                t("Feedback ID"),
                ":",
                /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: css$1.id, children: item2.id }),
                /* @__PURE__ */ jsxRuntimeExports.jsx(
                  "div",
                  {
                    className: css$1.copyIcon,
                    onClick: () => {
                      clipboardExports.copy(item2.id);
                      staticMethods.success(t("复制成功"));
                    },
                    children: /* @__PURE__ */ jsxRuntimeExports.jsx(RectCopyIcon, {})
                  }
                )
              ] }),
              /* @__PURE__ */ jsxRuntimeExports.jsxs(
                "div",
                {
                  className: css$1.right,
                  onClick: () => {
                    btnDetail(item2);
                  },
                  children: [
                    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: t(
                      item2.state == 2 ? t("Not adopted") : item2.state == 1 || item2.state == 3 ? t("Adopted") : t("Pendente")
                    ) }),
                    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$1.arrowIcon, children: /* @__PURE__ */ jsxRuntimeExports.jsx(ArrowLeftInMineIcon, {}) })
                  ]
                }
              )
            ] }),
            /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.listContent, children: [
              /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.updateTime, children: [
                /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: t("Feed Content") }),
                /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: customFormatTimer(item2.submit_time) })
              ] }),
              /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$1.listText, children: item2.content })
            ] }),
            item2.state != 0 && /* @__PURE__ */ jsxRuntimeExports.jsxs(jsxRuntimeExports.Fragment, { children: [
              /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$1.line }),
              /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.listContent, children: [
                /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.updateTime, children: [
                  /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { children: [
                    t("Official answer"),
                    ":"
                  ] }),
                  /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: customFormatTimer(item2.updated_at) })
                ] }),
                /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$1.listText, children: item2.reply_content })
              ] })
            ] })
          ] }, index);
        }) : /* @__PURE__ */ jsxRuntimeExports.jsxs(jsxRuntimeExports.Fragment, { children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$1.detailImg, children: itemDetail && itemDetail.attachment_url && /* @__PURE__ */ jsxRuntimeExports.jsx(jsxRuntimeExports.Fragment, { children: itemDetail.attachment_type == "2" ? /* @__PURE__ */ jsxRuntimeExports.jsx("video", { onClick: handleVideoClick, ref: videoRef, children: /* @__PURE__ */ jsxRuntimeExports.jsx(
            "source",
            {
              src: "".concat(window.location.origin).concat(itemDetail.attachment_url),
              type: "video/mp4"
            }
          ) }) : /* @__PURE__ */ jsxRuntimeExports.jsx(
            "img",
            {
              src: "".concat(window.location.origin).concat(itemDetail.attachment_url)
            }
          ) }) }),
          /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.detailTime, children: [
            /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: t("Feed Content") }),
            /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: customFormatTimer(itemDetail.submit_time) })
          ] }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$1.detailContent, children: /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$1.text, children: itemDetail.content }) }),
          itemDetail.state != 0 && /* @__PURE__ */ jsxRuntimeExports.jsxs(jsxRuntimeExports.Fragment, { children: [
            /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$1.line }),
            /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.updatedAt, children: [
              /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: t("Official answer") }),
              /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: customFormatTimer(itemDetail.updated_at) })
            ] }),
            /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$1.replyContent, children: /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$1.text, children: itemDetail.reply_content }) })
          ] })
        ] })
      }
    ) }) })
  ] });
};
const svg_theme_fill_color = "_svg_theme_fill_color_17335_3";
const ServiceBox$1 = "_ServiceBox_17335_55";
const contentBox = "_contentBox_17335_60";
const online = "_online_17335_63";
const left = "_left_17335_134";
const right = "_right_17335_140";
const title = "_title_17335_143";
const desc = "_desc_17335_178";
const btn = "_btn_17335_245";
const telegram = "_telegram_17335_289";
const content = "_content_17335_60";
const img = "_img_17335_419";
const telegramContent = "_telegramContent_17335_493";
const middle = "_middle_17335_576";
const css = {
  svg_theme_fill_color,
  ServiceBox: ServiceBox$1,
  contentBox,
  online,
  left,
  right,
  title,
  desc,
  btn,
  telegram,
  content,
  img,
  telegramContent,
  middle
};
const ServiceBox = () => {
  const [customerList, setCustomerList] = reactExports.useState([]);
  const [onlineService, setOnlineService] = reactExports.useState({});
  const { t, i18n } = useTranslation();
  const getOnlineService = async () => {
    const [res, error] = await getMemberCustomerList({
      flag: "1"
    });
    if (error)
      return;
    if (res && res.length > 0) {
      setOnlineService(res[0]);
    }
  };
  const getCustomerList = async () => {
    const [res, error] = await getMemberCustomerList({
      flag: "3"
    });
    if (error)
      return;
    setCustomerList(res || []);
  };
  const onlineObj = reactExports.useMemo(() => {
    if (onlineService.items && onlineService.items.length > 0) {
      return {
        im: onlineService.items[0].im,
        link: onlineService.items[0].link,
        name: onlineService.items[0].name,
        remark: onlineService.items[0].remark,
        status: onlineService.items[0].status
      };
    }
    return {};
  }, [onlineService]);
  reactExports.useEffect(() => {
    getCustomerList();
    getOnlineService();
  }, []);
  return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.ServiceBox, children: /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.contentBox, children: [
    onlineObj.im && onlineObj.status == 2 && /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.online, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { className: css.left, src: onlineObj.im, remote: true, isGame: true }),
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.right, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.title, children: onlineObj.name }),
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.desc, children: onlineObj.remark }),
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          Button,
          {
            className: css.btn,
            onClick: () => {
              if (!onlineObj.link) {
                Message$1.error(t("暂无客服"));
                return;
              }
              window.open(onlineObj.link, "_blank");
            },
            children: t("现在联系")
          }
        )
      ] })
    ] }),
    customerList && customerList.map((item2, index) => {
      var _a, _b, _c;
      item2.items = (_a = item2.items) == null ? void 0 : _a.filter((i) => i.status == 2);
      return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { children: [
        ((_b = item2.items) == null ? void 0 : _b.length) ? /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.telegram, children: /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.content, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { className: css.img, src: item2.im, remote: true, isGame: true }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("span", { children: item2.title })
        ] }) }) : null,
        ((_c = item2.items) == null ? void 0 : _c.length) ? item2.items.map((text2, i) => {
          return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.telegramContent, children: [
            /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { className: css.left, src: text2.im, remote: true, isGame: true }),
            /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.middle, children: [
              /* @__PURE__ */ jsxRuntimeExports.jsx("p", { children: text2.name }),
              /* @__PURE__ */ jsxRuntimeExports.jsx("span", { children: text2.remark })
            ] }),
            /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.right, children: /* @__PURE__ */ jsxRuntimeExports.jsx(
              Button,
              {
                className: css.btn,
                onClick: () => {
                  window.open(text2.link, "_blank");
                },
                children: t("现在联系")
              }
            ) })
          ] }, i);
        }) : null
      ] }, index);
    })
  ] }) });
};
const Message = () => {
  const { getMessageNumBySotre } = useMessageStore();
  const search = window.location.search;
  const params = new URLSearchParams(search);
  const to = params.get("service");
  useUserInfoStore();
  const state = useReactive({
    type: "",
    // message, notice,
    page: 0,
    total: 0,
    page_size: 10,
    messageList: [],
    selectList: [],
    isEdit: false
  });
  const onSelectType = (t) => {
    state.type = t;
  };
  const getMessageListByAction = async (page2 = 1) => {
    if (page2 === 1)
      state.total = 0;
    const [res] = await getMessageList({ page: page2, page_size: state.page_size });
    if (res) {
      if (page2 === 1) {
        state.messageList = res.d || [];
      } else {
        state.messageList = [...state.messageList, ...res.d];
      }
      state.page = page2;
      if (page2 === 1)
        state.total = res.t;
    }
  };
  useAsyncEffect(async () => {
    if (state.type === "message")
      await getMessageListByAction(1);
  }, [state.type]);
  reactExports.useEffect(() => {
    if (to) {
      state.type = "service";
    } else {
      state.type = "message";
    }
    const onReceiveMessage = () => {
      getMessageListByAction(1);
    };
    events.on("ReceiveMessage", onReceiveMessage);
    return () => {
      events.off("ReceiveMessage", onReceiveMessage);
    };
  }, []);
  const updateIsEdit = (status) => {
    state.isEdit = status;
  };
  const onSelect = (id2) => {
    const selectList2 = state.selectList;
    const index = selectList2.indexOf(id2);
    if (index === -1) {
      selectList2.push(id2);
      state.selectList = [...selectList2];
      return;
    }
    selectList2.splice(index, 1);
    state.selectList = [...selectList2];
  };
  const onSelectAll = () => {
    const { messageList: messageList2, selectList: selectList2 } = state;
    if (messageList2.length === selectList2.length) {
      state.selectList = [];
    } else {
      state.selectList = [...messageList2.map((item2) => item2.id)];
    }
  };
  const deleteMessage = async () => {
    const { selectList: selectList2 } = state;
    if (selectList2.length === 0)
      return;
    await deleteUserMessage(
      { flag: 1, ids: selectList2.join(",") },
      { useLoading: true }
    );
    getMessageListByAction(1);
    getMessageNumBySotre();
  };
  const { type, messageList, isEdit, selectList, total, page } = state;
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$5.messageBox, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsx(
      Header,
      {
        type: state.type,
        onSelectType,
        selectList,
        messageList,
        onSelectAll,
        onDeleteMessage: deleteMessage,
        isEdit,
        updateIsEdit
      }
    ),
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$5.contentBox, children: /* @__PURE__ */ jsxRuntimeExports.jsxs(
      "div",
      {
        className: joinClass(
          css$5.inSetBox,
          type === "message" ? css$5.showMessage : type === "feedback" ? css$5.showFeedback : type === "service" ? "" : css$5.showNotice
        ),
        children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx(ServiceBox, {}),
          /* @__PURE__ */ jsxRuntimeExports.jsx(
            MessageBox,
            {
              type,
              messageList,
              isEdit,
              selectList,
              onSelect: (id2) => onSelect(id2),
              children: total > messageList.length ? /* @__PURE__ */ jsxRuntimeExports.jsx(
                LoadMore,
                {
                  className: css$5.loadMoreBtn,
                  onClick: () => {
                    getMessageListByAction(page + 1);
                  }
                }
              ) : null
            }
          ),
          /* @__PURE__ */ jsxRuntimeExports.jsx(NoticeBox, { type }),
          /* @__PURE__ */ jsxRuntimeExports.jsx(Feedback, { type })
        ]
      }
    ) })
  ] });
};
export {
  Message as default
};
