#!/usr/bin/env python
# encoding: utf-8
from flask import Flask, request, jsonify, json

app = Flask(__name__)


@app.route('/')
def index():
    return jsonify({'health': 'ok'})


@app.route('/', methods=['POST'])
def validate():
    data = request.data
    # @TODO: Validate data
    response = app.response_class(
        response=json.dumps(data),
        status=200,
        mimetype='application/json'
    )
    return response


if __name__ == "__main__":
    app.run()
