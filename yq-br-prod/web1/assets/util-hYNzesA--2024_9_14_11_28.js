import { A as useNavigate } from "./index-CKtHrVPI-2024_9_14_11_28.js";
const useActivityNavigate = () => {
  const navigate = useNavigate();
  return {
    switchPage(item) {
      if (item.flag === "invite") {
        navigate("/activity/recommend-friends");
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
      if (item.flag === "bet") {
        navigate("/activity/active-bet/".concat(item.id, "/").concat(item.flag));
        return;
      }
      navigate("/activity-detail/".concat(item.id, "/").concat(item.flag));
    }
  };
};
export {
  useActivityNavigate as u
};
