import api from './index'
import Config from '../config/app'

const { http, search } = api

/**
 * ===================
 * Supplier API
 * ===================
 */
export default {
  baseURL: `${Config.services.api.url}/api`,
  url: 'suppliers',
  http,
  search,
}
