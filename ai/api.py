#!/usr/bin/env python
# encoding: utf-8
from flask import Flask, request, jsonify, json
from ai.main import Evaluator

app = Flask(__name__)
evaluator = Evaluator()


@app.route('/')
def index():
    return jsonify({'health': 'ok'})


@app.route('/', methods=['POST'])
def validate():
    if (request.data):
        content = request.get_json(silent=True)
        text = content['body']
    else:
        text = request.form['body']
    outcome = evaluator.evaluate(text).tolist()
    response = app.response_class(
        response=json.dumps(outcome[0]),
        status=200,
        mimetype='application/json'
    )
    return response


if __name__ == "__main__":
    evaluator.init()
    app.run()
