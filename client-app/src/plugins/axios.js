// utils/api.js
import axios from 'axios'

const api = axios.create({
  baseURL: 'https://www.kuliah-oskhar.my.id/api/v1',
})

api.interceptors.request.use(config => {
  const token = localStorage.getItem('token')
  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  }
  
  return config
}, error => Promise.reject(error))

export default api
