import { r as reactExports, N as jsxRuntimeExports, Q as joinClass, V as css$4, v as useUserInfoStore, T as trans, bt as inputPwdStrLengthTest, bu as postMemberPasswordUpdate, a9 as Message, S as Image, bv as getMemberAvatarUpdate, bw as postMemberBindEmail, W as Modal, A as useNavigate, aW as countryCode, bx as postMemberUpdate } from "./index-CKtHrVPI-2024_9_14_11_28.js";
import { n as Form, P as PopCloseIcon, o as Input, p as PasswordFullIcon, B as Button, q as customFormatTimer, r as Picker, U as UserFullIcon, s as PixAccountIcon, t as PhoneIcon } from "./App-BLdT6wOK-2024_9_14_11_28.js";
const SvgIcon = (props) => /* @__PURE__ */ reactExports.createElement("svg", { width: 24, height: 24, viewBox: "0 0 24 24", fill: "none", xmlns: "http://www.w3.org/2000/svg", ...props }, /* @__PURE__ */ reactExports.createElement("path", { d: "M21.1667 20.25H2.83333C2.561 20.25 2.30253 20.1906 2.07017 20.0841L9.50372 12.6506L10.0936 12.982C11.1587 13.5805 12.4612 13.57 13.5166 12.9544L14.3775 12.4522C14.4162 12.5179 14.4637 12.5798 14.5201 12.6362L21.9558 20.0719C21.7168 20.1861 21.4492 20.25 21.1667 20.25Z", fill: "#9D9D9D" }), /* @__PURE__ */ reactExports.createElement("path", { d: "M22.9971 18.5205C22.999 18.4861 23 18.4515 23 18.4167V7.4228L15.9889 11.5123L22.9971 18.5205Z", fill: "#9D9D9D" }), /* @__PURE__ */ reactExports.createElement("path", { d: "M7.8437 11.7178L1 7.87261V18.4167C1 18.4636 1.00177 18.5102 1.00524 18.5563L7.8437 11.7178Z", fill: "#9D9D9D" }), /* @__PURE__ */ reactExports.createElement("path", { d: "M1 5.58333V5.76971L10.9916 11.3837C11.4899 11.6636 12.0992 11.6587 12.5928 11.3708L22.9801 5.31202C22.8489 4.42815 22.087 3.75 21.1667 3.75H2.83333C1.82081 3.75 1 4.57081 1 5.58333Z", fill: "#9D9D9D" }));
const EmailIcon = ({ className } = {}) => {
  return /* @__PURE__ */ jsxRuntimeExports.jsx(SvgIcon, { className: joinClass(css$4.defaultCss, className) });
};
const svg_theme_fill_color$3 = "_svg_theme_fill_color_su9d6_3";
const infoContent = "_infoContent_su9d6_55";
const headerInfo = "_headerInfo_su9d6_64";
const img$1 = "_img_su9d6_70";
const textTop = "_textTop_su9d6_169";
const container = "_container_su9d6_172";
const name = "_name_su9d6_301";
const nameGray = "_nameGray_su9d6_361";
const rightBtn = "_rightBtn_su9d6_439";
const bg = "_bg_su9d6_528";
const birthText = "_birthText_su9d6_786";
const btnContainer = "_btnContainer_su9d6_845";
const submitButton = "_submitButton_su9d6_853";
const submitBtn = "_submitBtn_su9d6_856";
const btnRetornar = "_btnRetornar_su9d6_864";
const birthContainer = "_birthContainer_su9d6_968";
const prefix = "_prefix_su9d6_983";
const formList = "_formList_su9d6_988";
const iconSize$1 = "_iconSize_su9d6_992";
const input = "_input_su9d6_1020";
const css$3 = {
  svg_theme_fill_color: svg_theme_fill_color$3,
  infoContent,
  headerInfo,
  img: img$1,
  textTop,
  container,
  name,
  nameGray,
  rightBtn,
  bg,
  birthText,
  btnContainer,
  submitButton,
  submitBtn,
  btnRetornar,
  birthContainer,
  prefix,
  formList,
  iconSize: iconSize$1,
  input
};
const svg_theme_fill_color$2 = "_svg_theme_fill_color_jmx4m_3";
const password = "_password_jmx4m_55";
const title$2 = "_title_jmx4m_146";
const tips = "_tips_jmx4m_197";
const img1$2 = "_img1_jmx4m_287";
const empty$2 = "_empty_jmx4m_290";
const empty1$2 = "_empty1_jmx4m_293";
const close$2 = "_close_jmx4m_296";
const eight$2 = "_eight_jmx4m_315";
const iconSize = "_iconSize_jmx4m_319";
const css$2 = {
  svg_theme_fill_color: svg_theme_fill_color$2,
  password,
  title: title$2,
  tips,
  img1: img1$2,
  empty: empty$2,
  empty1: empty1$2,
  close: close$2,
  eight: eight$2,
  iconSize
};
const LoginPassword = ({ onClose }) => {
  reactExports.useState("");
  useUserInfoStore();
  const [form] = Form.useForm();
  const close2 = () => {
    onClose && onClose();
  };
  const submit = async (values) => {
    const [, err] = await postMemberPasswordUpdate({
      ty: 1,
      old_password: values.old_password,
      password: values.password
    });
    if (err) {
      return;
    }
    Message.success(trans("修改成功"));
    close2();
  };
  return /* @__PURE__ */ jsxRuntimeExports.jsxs(
    "div",
    {
      className: css$2.password,
      onClick: () => {
        close2();
      },
      children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx(PopCloseIcon, { className: css$2.close, onClick: onClose }),
        /* @__PURE__ */ jsxRuntimeExports.jsxs(
          "div",
          {
            onClick: (e) => {
              e.stopPropagation();
            },
            children: [
              /* @__PURE__ */ jsxRuntimeExports.jsx("p", { className: css$2.title, children: trans("登录密码") }),
              /* @__PURE__ */ jsxRuntimeExports.jsx("p", { className: css$2.tips, children: trans("保持定期更改密码的习惯，您的账户会更安全") }),
              /* @__PURE__ */ jsxRuntimeExports.jsxs(
                Form,
                {
                  form,
                  size: "small",
                  initialValues: {
                    old_password: "",
                    password: "",
                    confirmPassword: ""
                  },
                  onFinish: (values) => {
                    submit(values);
                  },
                  children: [
                    /* @__PURE__ */ jsxRuntimeExports.jsx(
                      Form.Field,
                      {
                        name: "old_password",
                        rules: [
                          { required: true, message: trans("请输入密码") },
                          {
                            pattern: inputPwdStrLengthTest,
                            message: trans("必须是6-20个英文字母和数字的组合")
                          }
                        ],
                        children: /* @__PURE__ */ jsxRuntimeExports.jsx(
                          Input,
                          {
                            placeholder: "".concat(trans("请输入密码")),
                            noBg: true,
                            clearable: true,
                            type: "password",
                            prefix: /* @__PURE__ */ jsxRuntimeExports.jsx(PasswordFullIcon, { className: css$2.iconSize })
                          }
                        )
                      }
                    ),
                    /* @__PURE__ */ jsxRuntimeExports.jsx(
                      Form.Field,
                      {
                        name: "password",
                        rules: [
                          { required: true, message: trans("请输入新密码") },
                          {
                            pattern: inputPwdStrLengthTest,
                            message: trans("必须是6-20个英文字母和数字的组合")
                          }
                        ],
                        children: /* @__PURE__ */ jsxRuntimeExports.jsx(
                          Input,
                          {
                            type: "password",
                            clearable: true,
                            placeholder: "".concat(trans("请输入新密码")),
                            noBg: true,
                            prefix: /* @__PURE__ */ jsxRuntimeExports.jsx(PasswordFullIcon, { className: css$2.iconSize })
                          }
                        )
                      }
                    ),
                    /* @__PURE__ */ jsxRuntimeExports.jsx(
                      Form.Field,
                      {
                        name: "confirmPassword",
                        rules: [
                          { required: true, message: trans("请重新输入新密码") },
                          {
                            pattern: inputPwdStrLengthTest,
                            message: trans("必须是6-20个英文字母和数字的组合")
                          },
                          {
                            validator: (rule, value2, callback) => {
                              if (value2 && value2 !== form.getFieldValue("password")) {
                                callback(trans("请重新输入新密码"));
                              } else {
                                callback();
                              }
                            }
                          }
                        ],
                        children: /* @__PURE__ */ jsxRuntimeExports.jsx(
                          Input,
                          {
                            type: "password",
                            clearable: true,
                            placeholder: "".concat(trans("请重新输入新密码")),
                            noBg: true,
                            prefix: /* @__PURE__ */ jsxRuntimeExports.jsx(PasswordFullIcon, { className: css$2.iconSize })
                          }
                        )
                      }
                    ),
                    /* @__PURE__ */ jsxRuntimeExports.jsx(Form.Field, { children: /* @__PURE__ */ jsxRuntimeExports.jsx(
                      Button,
                      {
                        block: true,
                        onClick: () => {
                          form.submit();
                        },
                        children: trans("确认")
                      }
                    ) })
                  ]
                }
              )
            ]
          }
        )
      ]
    }
  );
};
const svg_theme_fill_color$1 = "_svg_theme_fill_color_1kqpr_3";
const avatar = "_avatar_1kqpr_55";
const title$1 = "_title_1kqpr_149";
const img1$1 = "_img1_1kqpr_206";
const empty$1 = "_empty_1kqpr_209";
const empty1$1 = "_empty1_1kqpr_212";
const close$1 = "_close_1kqpr_215";
const eight$1 = "_eight_1kqpr_236";
const btn$1 = "_btn_1kqpr_239";
const avatarContainer = "_avatarContainer_1kqpr_242";
const img = "_img_1kqpr_206";
const active = "_active_1kqpr_263";
const none = "_none_1kqpr_341";
const checkd = "_checkd_1kqpr_344";
const css$1 = {
  svg_theme_fill_color: svg_theme_fill_color$1,
  avatar,
  title: title$1,
  img1: img1$1,
  empty: empty$1,
  empty1: empty1$1,
  close: close$1,
  eight: eight$1,
  btn: btn$1,
  avatarContainer,
  img,
  active,
  none,
  checkd
};
const checkMaps = {
  black: "/home/icons/checkd.webp",
  blue: "/home/icons/checkd_blue.webp",
  purple: "/home/icons/checkd_purple.webp",
  whiteRed: "/home/icons/checkd_white_red.webp",
  versaceYellow: "/home/icons/checkd_versaceYellow.webp",
  lancomePeach: "/home/icons/checkd_lancomePeach.webp",
  hermesOrange: "/home/icons/checkd_hermesOrange.webp",
  whiteBlue: "/home/icons/checkd_whiteBlue.webp",
  sk2: "/home/icons/checkd_sk2.webp",
  whiteYellow: "/home/icons/checkd_whiteYellow.webp",
  lightBrown: "/home/icons/checkd_lightBrown.webp",
  whiteOrange: "/home/icons/checkd_whiteOrange.webp",
  furlaBlue: "/home/icons/checkd_furlaBlue.webp",
  whitePink: "/home/icons/check_whitePink.webp",
  bvGreen: "/home/icons/check_bvGreen.webp",
  whiteBrown: "/home/icons/check_whiteBrown.webp",
  AnnaSuiPurple: "/home/icons/check_AnnaSuiPurple.webp",
  whitePurple: "/home/icons/check_whitePurple.webp",
  burgundyRed: "/home/icons/check_burgundyRed.webp",
  whiteDarkGreen: "/home/icons/check_whiteDarkGreen.webp",
  greenGold: "/home/icons/checkd_greenGold.webp",
  whiteBrownLauren: "/home/icons/check_whiteBrownLauren.webp",
  elsaPink: "/home/icons/check_elsaPink.webp",
  whiteRedGucci: "/home/icons/check_whiteRedGucci.webp",
  whiteBlack: "/home/icons/check_whiteBlack.webp",
  bvlgariBrown: "/home/icons/check_bvlgariBrown.webp"
};
const avatarList = [
  1,
  2,
  3,
  4,
  5,
  6,
  7,
  8,
  9,
  10,
  11,
  12,
  13,
  14,
  15,
  16,
  17,
  18,
  19,
  20
];
const Avatar = (props) => {
  const { theme } = useUserInfoStore();
  const [checked, setChecked] = reactExports.useState(props.defaultValue);
  reactExports.useEffect(() => {
    setChecked(props.defaultValue - 1);
  }, [props.defaultValue]);
  const onClose = () => {
    props.onClose && props.onClose();
  };
  const submit = async (params) => {
    console.error("checked", checked);
    const [res, err] = await getMemberAvatarUpdate({ id: checked + 1 });
    if (!err) {
      Message.success(trans("修改成功"));
      props.onClose && props.onClose();
    }
  };
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.avatar, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsx(PopCloseIcon, { className: css$1.close, onClick: onClose }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs(
      "div",
      {
        onClick: (e) => {
          e.stopPropagation();
        },
        children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("p", { className: css$1.title, children: trans("更换头像") }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$1.avatarContainer, children: avatarList.map((item, index) => /* @__PURE__ */ jsxRuntimeExports.jsxs(
            "div",
            {
              className: checked == index ? css$1.active : "",
              onClick: (e) => {
                e.stopPropagation();
                setChecked(index);
              },
              children: [
                /* @__PURE__ */ jsxRuntimeExports.jsx(
                  Image,
                  {
                    className: css$1.img,
                    src: "/home/avatar/avatar".concat(index + 1, ".webp")
                  }
                ),
                /* @__PURE__ */ jsxRuntimeExports.jsx(
                  Image,
                  {
                    className: joinClass(
                      css$1.checkd,
                      checked == index ? "" : css$1.none
                    ),
                    src: checkMaps[theme] || "/home/icons/checkd.webp"
                  }
                )
              ]
            },
            index
          )) }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$1.btn, children: /* @__PURE__ */ jsxRuntimeExports.jsx(
            Button,
            {
              block: true,
              onClick: () => {
                submit();
              },
              children: trans("保存")
            }
          ) })
        ]
      }
    )
  ] });
};
const svg_theme_fill_color = "_svg_theme_fill_color_1l31v_3";
const email = "_email_1l31v_55";
const title = "_title_1l31v_143";
const img1 = "_img1_1l31v_197";
const empty = "_empty_1l31v_215";
const empty1 = "_empty1_1l31v_218";
const close = "_close_1l31v_221";
const eight = "_eight_1l31v_243";
const btn = "_btn_1l31v_246";
const css = {
  svg_theme_fill_color,
  email,
  title,
  img1,
  empty,
  empty1,
  close,
  eight,
  btn
};
const Email = (props) => {
  var _a;
  const [form] = Form.useForm();
  useUserInfoStore();
  const onClose = () => {
    props.onClose && props.onClose();
  };
  const submit = async (params) => {
    if (props.defaultValue && params.email === props.defaultValue) {
      Message.error(trans("新邮箱不能与旧邮箱相同"));
      return;
    }
    const [res, err] = await postMemberBindEmail(params);
    if (err) {
      return;
    }
    Message.success(props.defaultValue ? trans("修改成功") : trans("绑定成功"));
    onClose();
  };
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.email, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsx(PopCloseIcon, { className: css.close, onClick: onClose }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs(
      "div",
      {
        onClick: (e) => {
          e.stopPropagation();
        },
        children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("p", { className: css.title, children: trans("Email") }),
          /* @__PURE__ */ jsxRuntimeExports.jsxs(
            Form,
            {
              form,
              size: "small",
              initialValues: {
                email: (_a = props.defaultValue) != null ? _a : ""
              },
              onFinish: (values) => {
                submit(values);
              },
              children: [
                /* @__PURE__ */ jsxRuntimeExports.jsx(
                  Form.Field,
                  {
                    name: "email",
                    rules: [
                      { required: true, message: trans("请输入邮箱地址") },
                      { type: "email", message: trans("请输入正确的电子邮件地址") }
                    ],
                    children: /* @__PURE__ */ jsxRuntimeExports.jsx(
                      Input,
                      {
                        placeholder: "".concat(trans("请输入邮箱地址")),
                        noBg: true,
                        prefix: /* @__PURE__ */ jsxRuntimeExports.jsx(EmailIcon, { className: css.img1 })
                      }
                    )
                  }
                ),
                /* @__PURE__ */ jsxRuntimeExports.jsx(Form.Field, { children: /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.btn, children: /* @__PURE__ */ jsxRuntimeExports.jsx(
                  Button,
                  {
                    block: true,
                    onClick: () => {
                      form.submit();
                    },
                    children: trans("确认")
                  }
                ) }) })
              ]
            }
          )
        ]
      }
    )
  ] });
};
const monthList = [
  { label: "01", value: "01" },
  { label: "02", value: "02" },
  { label: "03", value: "03" },
  { label: "04", value: "04" },
  { label: "05", value: "05" },
  { label: "06", value: "06" },
  { label: "07", value: "07" },
  { label: "08", value: "08" },
  { label: "09", value: "09" },
  { label: "10", value: "10" },
  { label: "11", value: "11" },
  { label: "12", value: "12" }
];
const FormList = () => {
  const { info, getUserInfoByStore, theme } = useUserInfoStore();
  const [form] = Form.useForm();
  const [month, setMonth] = reactExports.useState("");
  const navigate = useNavigate();
  const submit = async (params) => {
    console.error(params);
    console.error(info.whatsapp);
    const birth = "".concat(params.year, "-").concat(params.month < 10 ? "0" + Number(params.month) : params.month, "-").concat(params.day < 10 ? "0" + Number(params.day) : params.day);
    const _params = {
      birth,
      whatsapp: params.whatsapp,
      facebook: params.facebook,
      telegram: params.telegram,
      twitter: params.twitter
    };
    if (!params.year) {
      delete _params.birth;
    }
    if ((info == null ? void 0 : info.whatsapp) == params.whatsapp && (info == null ? void 0 : info.facebook) == params.facebook && (info == null ? void 0 : info.telegram) == params.telegram && (info == null ? void 0 : info.twitter) == params.twitter && Number(customFormatTimer(info.birth, "DD")) == Number(params.day) && Number(customFormatTimer(info.birth, "MM")) == Number(params.month) && Number(customFormatTimer(info.birth, "YYYY")) == Number(params.year)) {
      Message.info(trans("Não efetuou quaisquer edições"));
      return;
    }
    const [res, err] = await postMemberUpdate(_params);
    if (err) {
      return;
    }
    Message.success(trans("Informações pessoais alteradas com sucesso"));
    getUserInfoByStore();
  };
  reactExports.useEffect(() => {
    if (info) {
      if (info == null ? void 0 : info.whatsapp) {
        form.setFieldsValue({
          whatsapp: info.whatsapp
        });
      }
      if (info == null ? void 0 : info.facebook) {
        form.setFieldsValue({
          facebook: info.facebook
        });
      }
      if (info == null ? void 0 : info.telegram) {
        form.setFieldsValue({
          telegram: info.telegram
        });
      }
      if (info == null ? void 0 : info.twitter) {
        form.setFieldsValue({
          twitter: info.twitter
        });
      }
      if ((info == null ? void 0 : info.birth) && (info == null ? void 0 : info.birth) != 0) {
        form.setFieldsValue({
          day: customFormatTimer(info.birth, "DD"),
          month: customFormatTimer(info.birth, "MM"),
          year: customFormatTimer(info.birth, "YYYY")
        });
      } else {
        form.setFieldsValue({
          day: customFormatTimer(""),
          month: customFormatTimer(""),
          year: customFormatTimer("")
        });
      }
    }
  }, [info]);
  const isSetBirth = (() => {
    if (info) {
      return (info == null ? void 0 : info.birth) && (info == null ? void 0 : info.birth) != "0";
    }
    return false;
  })();
  return /* @__PURE__ */ jsxRuntimeExports.jsxs(
    Form,
    {
      form,
      size: "small",
      initialValues: {
        whatsapp: "",
        facebook: "",
        telegram: "",
        twitter: "",
        day: "",
        month: "",
        year: ""
      },
      onFinish: (values) => {
        submit(values);
      },
      children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          Form.Field,
          {
            name: "whatsapp",
            rules: [
              // { required: true, message: '输入6-40个数字' },
              {
                pattern: /^[0-9]{6,40}$/,
                message: trans("输入6-40个数字")
              }
            ],
            children: /* @__PURE__ */ jsxRuntimeExports.jsx(
              Input,
              {
                className: css$3.input,
                type: "text",
                clearable: true,
                placeholder: trans("请输入WhatsApp"),
                prefix: /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { className: css$3.prefix, src: "/home/icons/whatsapp.webp" })
              }
            )
          }
        ),
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          Form.Field,
          {
            name: "facebook",
            rules: [
              // { required: true, message: `Apenas é permitido introduzir letras, números e caracteres especiais  ${'@._-\ '}` },
              {
                pattern: /^[\w@._-]{6,40}$/,
                message: "".concat(trans("输入6-40 只能输入字母、数字和特殊字符"), " ").concat("@._- ")
              }
            ],
            children: /* @__PURE__ */ jsxRuntimeExports.jsx(
              Input,
              {
                type: "text",
                className: css$3.input,
                clearable: true,
                placeholder: trans("请输入您的脸书账号"),
                prefix: /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { className: css$3.prefix, src: "/home/icons/facebook.webp" })
              }
            )
          }
        ),
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          Form.Field,
          {
            name: "telegram",
            rules: [
              // { required: true, message: 'Introduza 5-40 letras/números/sublinhados' },
              {
                pattern: /^[0-90-9A-Za-z]{6,40}$/,
                message: trans("输入6-40个字母/数字/下划线")
              }
            ],
            children: /* @__PURE__ */ jsxRuntimeExports.jsx(
              Input,
              {
                type: "text",
                className: css$3.input,
                clearable: true,
                placeholder: trans("请输入您的 Telegram 用户名"),
                prefix: /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { className: css$3.prefix, src: "/home/icons/telegram.webp" })
              }
            )
          }
        ),
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          Form.Field,
          {
            name: "twitter",
            rules: [
              // { required: true, message: 'Introduza 4-40 letras/números/símbolos' },
              {
                pattern: /^[0-9A-Za-z]{6,40}$/,
                message: trans("输入6-40个字母/数字/符号")
              }
            ],
            children: /* @__PURE__ */ jsxRuntimeExports.jsx(
              Input,
              {
                type: "text",
                className: css$3.input,
                clearable: true,
                placeholder: trans("输入推特账号"),
                prefix: /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { className: css$3.prefix, src: "/home/icons/twitter.webp" })
              }
            )
          }
        ),
        /* @__PURE__ */ jsxRuntimeExports.jsx("p", { className: css$3.birthText, children: trans("选择出生日期（一旦设置，无法修改）") }),
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$3.birthContainer, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx(
            Form.Field,
            {
              name: "day",
              rules: [
                // { required: true, message: '请输入' },
                {
                  pattern: /^((0?[1-9])|([1-2][0-9])|30|31)$/,
                  message: trans("请输入正确日期")
                }
              ],
              children: /* @__PURE__ */ jsxRuntimeExports.jsx(
                Input,
                {
                  type: "text",
                  clearable: true,
                  radius: true,
                  disabled: isSetBirth,
                  className: joinClass(css$3.inputHeight, css$3.input),
                  placeholder: trans("天")
                }
              )
            }
          ),
          /* @__PURE__ */ jsxRuntimeExports.jsx(
            Form.Field,
            {
              name: "month",
              rules: [
                // { required: true, message: '请选择' }
              ],
              children: info && /* @__PURE__ */ jsxRuntimeExports.jsx(
                Picker,
                {
                  label: "",
                  defaultValue: customFormatTimer(info.birth, "MM"),
                  items: monthList,
                  placeholder: trans("月"),
                  disabled: isSetBirth,
                  newPickerBg: true,
                  onChange: (_value) => {
                    setMonth(_value);
                  }
                },
                info.birth
              )
            }
          ),
          /* @__PURE__ */ jsxRuntimeExports.jsx(
            Form.Field,
            {
              name: "year",
              rules: [
                // { required: true, message: '请输入出生年份' },
                {
                  pattern: /^(1949|19[5-9]\d|20\d{2}|2006)$/,
                  message: trans("生日日期格式错误")
                }
              ],
              children: /* @__PURE__ */ jsxRuntimeExports.jsx(
                Input,
                {
                  type: "text",
                  clearable: true,
                  radius: true,
                  disabled: isSetBirth,
                  className: joinClass(css$3.inputHeight, css$3.input),
                  placeholder: trans("年")
                }
              )
            }
          )
        ] }),
        /* @__PURE__ */ jsxRuntimeExports.jsx(Form.Field, { children: /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$3.btnContainer, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: /* @__PURE__ */ jsxRuntimeExports.jsx(
            Button,
            {
              className: joinClass(css$3.submitButton, css$3.btnRetornar),
              block: true,
              onClick: () => {
                navigate(-1);
              },
              type: "borderBtn",
              children: trans("返回")
            }
          ) }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: /* @__PURE__ */ jsxRuntimeExports.jsx(
            Button,
            {
              className: joinClass(css$3.submitButton, css$3.submitBtn),
              block: true,
              onClick: () => {
                form.submit();
              },
              children: trans("保存")
            }
          ) })
        ] }) })
      ]
    }
  );
};
const InputItem = () => {
  const { info, getUserInfoByStore, theme } = useUserInfoStore();
  const { isSetWithdrawPassword } = useUserInfoStore();
  const navigate = useNavigate();
  const [loginPwdStatus, setLoginPwdStatus] = reactExports.useState(false);
  const [emailStatus, setEmailStatus] = reactExports.useState(false);
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$3.formList, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: joinClass(css$3.textTop, css$3.bg), children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx(UserFullIcon, { className: css$3.iconSize }),
      /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: css$3.name, children: info == null ? void 0 : info.username })
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: joinClass(css$3.textTop, css$3.bg), children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx(PixAccountIcon, { className: css$3.iconSize }),
      /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: css$3.name, children: info == null ? void 0 : info.uid })
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: joinClass(css$3.container, css$3.textTop), children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx(PhoneIcon, { className: css$3.iconSize }),
      /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: (info == null ? void 0 : info.phone) ? css$3.name : css$3.nameGray, children: (info == null ? void 0 : info.phone) ? "".concat(countryCode, "-").concat(info == null ? void 0 : info.phone) : trans("链接您的手机") }),
      (info == null ? void 0 : info.phone) ? null : /* @__PURE__ */ jsxRuntimeExports.jsx(
        "span",
        {
          className: css$3.rightBtn,
          onClick: () => {
            navigate("/enter-login-psw");
          },
          children: trans("转到链接")
        }
      )
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs(
      "div",
      {
        className: joinClass(css$3.container, css$3.textTop),
        onClick: (e) => {
          if (isSetWithdrawPassword) {
            return;
          } else {
            navigate("/withdraw-set?to=withdraw");
          }
        },
        children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx(PasswordFullIcon, { className: css$3.iconSize }),
          /* @__PURE__ */ jsxRuntimeExports.jsx(
            "span",
            {
              className: (info == null ? void 0 : info.withdraw_pwd) == 0 || (info == null ? void 0 : info.withdraw_pwd) == "" ? css$3.nameGray : css$3.name,
              children: (info == null ? void 0 : info.withdraw_pwd) == 0 || (info == null ? void 0 : info.withdraw_pwd) == "" ? trans("提现密码") : "******"
            }
          )
        ]
      }
    ),
    /* @__PURE__ */ jsxRuntimeExports.jsxs(
      "div",
      {
        className: joinClass(css$3.container, css$3.textTop),
        onClick: (e) => {
          setLoginPwdStatus(true);
        },
        children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx(PasswordFullIcon, { className: css$3.iconSize }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: (info == null ? void 0 : info.password) == "" ? css$3.nameGray : css$3.name, children: (info == null ? void 0 : info.password) == "" ? "" : "******" }),
          /* @__PURE__ */ jsxRuntimeExports.jsx(
            "span",
            {
              className: css$3.rightBtn,
              onClick: (e) => {
                setLoginPwdStatus(true);
              },
              children: trans("修改")
            }
          )
        ]
      }
    ),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: joinClass(css$3.container, css$3.textTop), children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx(EmailIcon, { className: css$3.iconSize }),
      /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: (info == null ? void 0 : info.email) ? css$3.name : css$3.nameGray, children: (info == null ? void 0 : info.email) ? info == null ? void 0 : info.email : trans("Email") }),
      (info == null ? void 0 : info.email) ? null : /* @__PURE__ */ jsxRuntimeExports.jsx(
        "span",
        {
          className: css$3.rightBtn,
          onClick: (e) => {
            e.stopPropagation();
            setEmailStatus(true);
          },
          children: trans("修改")
        }
      )
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsx(Modal, { isOpen: loginPwdStatus, onClose: (e) => e && e.stopPropagation(), children: /* @__PURE__ */ jsxRuntimeExports.jsx(
      LoginPassword,
      {
        onClose: () => {
          setLoginPwdStatus(false);
          getUserInfoByStore();
        }
      }
    ) }),
    /* @__PURE__ */ jsxRuntimeExports.jsx(Modal, { isOpen: emailStatus, onClose: (e) => e && e.stopPropagation(), children: /* @__PURE__ */ jsxRuntimeExports.jsx(
      Email,
      {
        defaultValue: info == null ? void 0 : info.email,
        onClose: () => {
          setEmailStatus(false);
          getUserInfoByStore();
        }
      }
    ) })
  ] });
};
const PersonalInformation = () => {
  const { info, getUserInfoByStore, theme } = useUserInfoStore();
  Form.useForm();
  const [avatarStatus, setAvatarStatus] = reactExports.useState(false);
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$3.infoContent, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$3.headerInfo, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$3.img, children: /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { src: "/home/avatar/avatar".concat(info == null ? void 0 : info.avatar, ".webp") }) }),
      /* @__PURE__ */ jsxRuntimeExports.jsx(
        "p",
        {
          onClick: () => {
            setAvatarStatus(true);
          },
          children: trans("建立")
        }
      )
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsx(InputItem, {}),
    /* @__PURE__ */ jsxRuntimeExports.jsx(FormList, {}),
    /* @__PURE__ */ jsxRuntimeExports.jsx(Modal, { isOpen: avatarStatus, onClose: (e) => e && e.stopPropagation(), children: /* @__PURE__ */ jsxRuntimeExports.jsx(
      Avatar,
      {
        defaultValue: info == null ? void 0 : info.avatar,
        onClose: () => {
          setAvatarStatus(false);
          getUserInfoByStore();
        }
      }
    ) })
  ] });
};
export {
  PersonalInformation as default
};
