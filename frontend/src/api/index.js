import axios from 'axios'
import Config from '../config/app'

/**
 *============================================================
 * API
 * ===========================================================
 *
 * Initialize the axios instance with an Authorization header.
 * Refreshes expired token before am API request.
 *
 */
export default {
  /**
   * Creates an axios instance with an access token as authorization header
   *
   * @param String baseURL
   * @return {*} http
   */
  http(baseURL) {
    const http = axios.create({ baseURL })

    http.interceptors.request.use(async (config) => {
      /**
       * Set Headers config
       */
      config.headers.Accept = 'application/json'
      config.headers.Authorization = `Bearer ${Config.services.api.token}`

      return config
    })

    return http
  },

  /**
   * Display a list of the resource.
   *
   */
  search(params = null) {
    return this.http(this.baseURL).get(`${this.url}/search`, { params })
  },

  /**
   * Display the specified resource.
   *
   */
  show(id, params = null) {
    return this.http(this.baseURL).get(`${this.url}/${id}`, { params })
  },
}
