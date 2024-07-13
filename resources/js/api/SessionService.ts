import axios from "axios";
import { sessionPaths } from "@js/config/apiPaths";

const { setSelectedAccountPath } = sessionPaths;

export const setSelectedAccount = async (accountId: number) => {
    return await axios
        .post(setSelectedAccountPath, { accountId })
        .catch((error) => console.log(error)); // TODO: create error popup
};
