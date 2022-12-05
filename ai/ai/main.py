# Import packages
from sklearn.metrics import accuracy_score
from nltk.corpus import stopwords
import pandas as pd
import numpy as np
from sklearn.feature_extraction.text import CountVectorizer
from sklearn.model_selection import train_test_split
from sklearn.tree import DecisionTreeClassifier
import nltk
import re
import string


class Evaluator:
    def __init__(self):
        nltk.download('stopwords')
        self.stopword = set(stopwords.words('english'))
        self.stemmer = nltk.SnowballStemmer('english')

    def load_data(self, path):
        return pd.read_csv(path)

    def process_data(self, data):
        data['labels'] = data['class'].map({
            0: 'Hate Speech',
            1: 'Offensive Speech',
            2: 'Acceptable Speech'
        })
        data = data[['tweet', 'labels']]
        return data

    def clean(self, text):
        text = str(text).lower()
        text = re.sub('[.?]', '', text)
        text = re.sub('https?://\S+|www.\S+', '', text)
        text = re.sub('<.?>+', '', text)
        text = re.sub('[%s]' % re.escape(string.punctuation), '', text)
        text = re.sub('\n', '', text)
        text = re.sub('\w\d\w', '', text)
        text = [word for word in text.split(' ') if word not in self.stopword]
        text = ''.join(text)
        text = [self.stemmer.stem(word) for word in text.split(' ')]
        text = ''.join(text)
        return text

    def evaluate(self, text):
        data = self.load_data('data/tweets.csv')
        data = self.process_data(data)
        data['tweet'] = data['tweet'].apply(self.clean)
        x = np.array(data['tweet'])
        y = np.array(data['labels'])
        cv = CountVectorizer()
        X = cv.fit_transform(x)

        # Splitting the Data
        X_train, X_test, y_train, y_test = train_test_split(
            X, y, test_size=0.33, random_state=42)

        # Model building
        model = DecisionTreeClassifier()

        # Training the model
        model.fit(X_train, y_train)

        # Testing the model
        y_pred = model.predict(X_test)
        y_pred  # Accuracy score of the model
        print('Model accuracy score:', accuracy_score(y_test, y_pred))

        # Predicting the outcome
        text = cv.transform([text]).toarray()
        return model.predict(text)
