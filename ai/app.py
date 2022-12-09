#!/usr/bin/env python
# encoding: utf-8
from flask import Flask, request, jsonify, json, g
from ai.main import deviceSelect, loadModel, loadVocab, inference


app = Flask(__name__)


@app.before_request
def load_ai():
    device = deviceSelect()
    field = loadVocab('ai/vocab/TEXT_obj_kaggle_trained_2.pth')
    model = loadModel(
        'ai/model/textTransformer_states_kaggle_trained_2.pth',
        len(field.vocab),
        device
    )
    g.ai = {
        'model': model,
        'field': field,
        'device': device
    }


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
    try:
        outcome = inference(g.ai['model'], g.ai['field'], text, g.ai['device'])
        response = app.response_class(
            response=json.dumps(outcome),
            status=200,
            mimetype='application/json'
        )
        return response
    except Exception as e:
        response = app.response_class(
            response=json.dumps(outcome),
            status=500,
            mimetype='application/json'
        )
        return response


if __name__ == '__main__':
    app.run(debug=True)
    # inference
    # device = deviceSelect()
    # TEXT = loadVocab('ai/vocab/TEXT_obj_kaggle_trained_2.pth')
    # vocabSize = len(TEXT.vocab)
    # model = loadModel(
    #     'ai/model/textTransformer_states_kaggle_trained_2.pth', vocabSize, device)
    # print(inference(model, TEXT, 'The shit just blows me..claim you so faithful and down for somebody but still fucking with hoes!', device))
    # print(inference(model, TEXT, "!!! RT @mayasolovely: As a woman you shouldn't complain about cleaning up your house. &amp; as a man you should always take the trash out...", device))
    # print(inference(model, TEXT, "!!!!!!!!!!!!! RT @ShenikaRoberts: The shit you hear about me might be true or it might be faker than the bitch who told it to ya &#57361;", device))
