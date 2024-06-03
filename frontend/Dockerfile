FROM node:alpine

WORKDIR /app/frontend

COPY ./dist ./dist

RUN npm install --global serve

EXPOSE 3000

CMD ["npx", "serve", "-s", "dist"]