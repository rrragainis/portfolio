# Stage 1: Build
FROM node:20-alpine as build-stage

WORKDIR /app
COPY package*.json ./
RUN npm ci

COPY . .
RUN npm run build

# Stage 2: Serve with nginx
FROM nginx:stable-alpine as production-stage

# Install envsubst
RUN apk add --no-cache bash

# Copy built assets from build-stage
COPY --from=build-stage /app/dist /usr/share/nginx/html

# Copy nginx config
COPY nginx.conf /etc/nginx/templates/default.conf.template

# Set environment variables with defaults
ENV BACKEND_URL=http://localhost:8000
ENV PORT=80

# Expose port
EXPOSE ${PORT}

# Start Nginx
CMD ["/bin/sh", "-c", "envsubst '${BACKEND_URL}' < /etc/nginx/templates/default.conf.template > /etc/nginx/conf.d/default.conf && nginx -g 'daemon off;'"]

