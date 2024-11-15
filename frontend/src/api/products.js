import api from './index'
import Config from '../config/app'

const { http, show } = api

/**
 * ===================
 * Product API
 * ===================
 */
export default {
  baseURL: `${Config.services.api.url}/api`,
  url: 'products',
  http,
  show,
}
