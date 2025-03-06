FROM node:20.4

WORKDIR /usr/src/app

COPY ../../code/node/package*.json ./
RUN npm install

EXPOSE 4000
CMD ["sh", "-c", "npm install && node --env-file=.env index.js"]