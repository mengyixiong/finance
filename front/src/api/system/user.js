import request from '@/utils/request'

const prefix = "/system/user";

export function getPageConfig() {
  return request({
    url: prefix + '/page_config',
    method: 'get',
  })
}

export function getList(params) {
  return request({
    url: prefix,
    method: 'get',
    params
  })
}

export function addUser(data) {
  return request({
    url: prefix,
    method: 'post',
    data
  })
}
