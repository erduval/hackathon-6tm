# Utilisation d'une image Node.js 16 avec npm
FROM node:16
# Définir le répertoire de travail
WORKDIR /app

# Copier les fichiers package.json et package-lock.json
COPY package*.json ./

# Installer les dépendances du projet
RUN npm install

# Copier le reste des fichiers du projet
COPY . .

# Exposer le port utilisé par Vue.js
EXPOSE 8080

# Commande par défaut pour exécuter Vue.js
CMD ["npm", "run", "serve"]
