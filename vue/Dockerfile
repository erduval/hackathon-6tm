# Utilisation d'une image Node.js 16 avec npm
FROM node:16

# Copie du code Vue.js dans le conteneur
COPY ./ /app
WORKDIR /app

# Installation des dépendances Vue.js
RUN npm install

# Exposer le port utilisé par Vue.js
EXPOSE 8080

# Commande par défaut pour exécuter Vue.js
CMD ["npm", "run", "serve"]
