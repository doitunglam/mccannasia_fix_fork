import { ROUTES, LOGIN} from '@/services/api'
import {request, METHOD, removeAuthorization} from '@/utils/request'
export async function login(name, password){
// let result = {data: {}};
// console.log(name);
// console.log(password);
//   result.data.permissions = [{id: 'queryForm', operation: ['add', 'edit']}]
//   result.data.roles = [{id: 'admin', operation: ['add', 'edit', 'delete']}]
//   result.code = 0
//   result.message = "Login successfully"
//   const user = {
//     name: 'admin',
//     avatar: 'https://avatars0.githubusercontent.com/u/20942571?s=460&v=4',
//     address: 'Shanghai',
//     position: 'Frontend Engineer'
//   }
//   result.data.user = user
//   result.data.token = 'Authorization:' + Math.random()
//   result.data.expireAt = new Date(new Date().getTime() + 60 * 60 * 1000)
//   result.data.status = "success";
  // result.data.authorisation.token = "Authorization:" + Math.random();
  // return result
  return request(LOGIN, METHOD.POST, {
    phone: name,
    password: password
  })
}

export async function getRoutesConfig() {
  return request(ROUTES, METHOD.GET)
}

export function logout() {
  localStorage.removeItem(process.env.VUE_APP_ROUTES_KEY)
  localStorage.removeItem(process.env.VUE_APP_PERMISSIONS_KEY)
  localStorage.removeItem(process.env.VUE_APP_ROLES_KEY)
  removeAuthorization()
}
export default {
  login,
  logout,
  getRoutesConfig
}
