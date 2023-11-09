import request from '@/utils/request'

const prefix = "/data/account_title";

/**
 * 获取
 * @returns {AxiosPromise}
 */
export function getPageConfig() {
  return request({
    url: prefix + 'page_config',
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
