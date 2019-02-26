import { isArray } from "util";
import { ROLES } from '../app.constants';

export default {
    getAllRoles() {
        return ROLES;
    },
    getRoles(cod) {
        if (cod === undefined)
            return [];
        let thisRoles=[];
        for (let item of ROLES) {
            if (!(cod % item.id))
                thisRoles.push(item);
        }
        return thisRoles;
    },
  }
