// src/config/api.js
const API_BASE_URL = '/api'; // This will be proxied by Nginx to your backend

export default {
  PHOTOSHOP: {
    BASE: `${API_BASE_URL}/photoshops`,
  },
  // Add other API endpoints here
};
