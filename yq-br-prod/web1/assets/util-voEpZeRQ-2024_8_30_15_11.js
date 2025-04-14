import { x as useNavigate } from "./index-a_Ow1xUN-2024_8_30_15_11.js";
const useActivityNavigate = () => {
  const navigate = useNavigate();
  return {
    switchPage(item) {
      if (item.flag === "invite") {
        navigate("/activity/recommend-friends");
        return;
      }
      if (item.flag === "turntable") {
        navigate("/activity/lucky-wheel");
        return;
      }
      if (item.flag === "rescue_deposit") {
        navigate("/activity/rescue-deposit/".concat(item.id, "/").concat(item.flag));
        return;
      }
      if (item.flag === "single_topup") {
        navigate("/activity/top-up-winnings/".concat(item.id, "/").concat(item.flag));
        return;
      }
      navigate("/activity-detail/".concat(item.id, "/").concat(item.flag));
    }
  };
};
export {
  useActivityNavigate as u
};
