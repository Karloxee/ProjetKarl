pipeline {
    agent any

    environment {
        DOCKER_IMAGE = 'karloxe/devopscar'
        DOCKER_CREDENTIALS = 'docker-hub-credentials'
    }

    stages {
        stage('Cloner le code') {
            steps {
                git branch: 'master', url: 'https://github.com/Karloxee/ProjetKarl.git'
            }
        }

        stage('Construire l’image Docker') {
            steps {
                script {
                    sh "docker build -t $DOCKER_IMAGE:$BUILD_NUMBER ."
                }
            }
        }

        stage('Pousser sur Docker Hub') {
            steps {
                script {
                    withDockerRegistry([credentialsId: "$DOCKER_CREDENTIALS", url: ""]) {
                        sh "docker push $DOCKER_IMAGE:${BUILD_NUMBER}"
                    }
                }
            }
        }

        stage('Déployer avec Docker Compose') {
            steps {
                script {
                    sh "export BUILD_NUMBER=${BUILD_NUMBER} && docker-compose down"
                   //  sh "docker build --no-cache"
                    sh "export BUILD_NUMBER=${BUILD_NUMBER} && docker-compose  up -d"
                }
            }
        }
    }
}

