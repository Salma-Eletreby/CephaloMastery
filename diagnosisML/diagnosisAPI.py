from flask import Flask, jsonify, request
from flask_cors import CORS
import cv2
from math import *
from ultralytics import YOLO 
import os
import requests
from io import BytesIO
import numpy as np
from tensorflow.keras.preprocessing import image
from tensorflow.keras.models import load_model
from PIL import Image

app = Flask(__name__)
CORS(app)  # Configure CORS for the entire app

model = load_model("models/SymmetryModel.h5",compile=False)
image_url = "http://localhost/webservice/draftfile.php/5/user/draft/288592787/2.png?token=c475fa437f2a7f0901efee33e8e206dc"

def select_model_path(number):
    if number == "EOFS":
        return "models/SymmetryModel.h5"
    elif number == "EOFAS":
        return "models/SymmetrySev.h5"
    elif number == "EOFLVH":
        return "models/LowerLip.h5"
    elif number == "EOFLC":
        return "models/LipCompetence.h5"
    elif number == "EOFSSL":
        return "models/SmileLine.h5"
    elif number == "EOFSSA":
        return "models/SmileArcModel.h5"
    elif number == "EOFSDM":
        return "models/DentalMidline.h5"
    elif number == "EOFSDMSD":
        return "models/Shift.h5"
    elif number == "EOFSDMSDD":
        return "models/ShiftDistance.h5"
    elif number == "EOFSOC":
        return "models/UpperOcclusal.h5"
    elif number == "PD":
        return "models/Profile.h5"
    elif number == "PNA":
        return "models/NasolabialAngle.h5"
    elif number == "PMPA":
        return "models/MandibularPlane.h5"
    elif number == "PLFH":
        return "models/LowerFaceHeight.h5"
    else:
        return "Not found"
        
def select_class_names(number):
    if number == "EOFAS":
        return {0: "Mild", 1: "No Assymetry", 2: "Moderate"}
    elif number == "EOFLVH":
        return {0: "Increased", 1: "Normal", 2: "Reduced"}
    elif number == "EOFSDMSD":
        return {0: "No shift", 1: "Right side", 2: "Left side"}
    elif number == "EOFSDMSDD":
        return {0: "0", 1: "2", 2: "3"}
    elif number == "PD":
        return {0: "Concave", 1: "Convex", 2: "Straight"}
    elif number == "PNA":
        return {0: "Reduced", 1: "Increased", 2: "Normal"}
    elif number == "PMPA":
        return {0: "Normal", 1: "Increased", 2: "Reduced"}
    else:
        return null

def preprocess_image_url(image_url, target_size=(150, 150)):
    response = requests.get(image_url)
    img = Image.open(BytesIO(response.content))
    
    # Convert RGBA image to RGB
    if img.mode == 'RGBA':
        img = img.convert('RGB')
    
    img = img.resize(target_size)
    img_array = image.img_to_array(img)
    img_array /= 255.0  # Normalize pixel values
    return np.expand_dims(img_array, axis=0)

@app.route('/predict', methods=['POST'])
def get_keypoints():
    test_image_path= request.json.get("imageURL")
    number= request.json.get("model")

    preprocessed_image = preprocess_image_url(test_image_path)

    #Get the model path based on the Q number
    model_path = select_model_path(number)
    model = load_model(model_path,compile=False)
    # Make predictions
    prediction = model.predict(preprocessed_image)

    #Make predictions
    if number == "EOFAS" or number == "EOFLVH" or number == "EOFSDMSD" or number == "EOFSDMSDD" or number == "PD" or number == "PNA" or number == "PMPA":
        # Get the predicted class index
        class_names = select_class_names(number)
        predicted_class_index = np.argmax(prediction[0])

        # Get the corresponding class name
        predicted_class_name = class_names[predicted_class_index]

        return jsonify(predicted_class_name)
    elif number == "EOFS":
        # Output the prediction
        if prediction[0][0] >= 0.5:
            return jsonify("Yes")
        else:
            print("Predicted: No (Asymmetrical)")
            return jsonify("No")
    elif number == "EOFLC":
        # Output the prediction
        if prediction[0][0] >= 0.5:
            print("Predicted: Yes (Competent)")
            return jsonify("Competent")
        else:
            print("Predicted: No (Incompetent)")
            return jsonify("Incompetent")
    elif number == "EOFSSL":
        # Output the prediction
        if prediction[0][0] >= 0.5:
            print("Predicted: Normal")
            return jsonify("Normal")
        else:
            print("Predicted: High")
            return jsonify("High")
    elif number == "EOFSSA":
        # Interpret the prediction result
        labels = ['Flat', 'Reversed', 'Non Consonant', 'Consonant']  # Define the labels
        predicted_label_index = np.argmax(prediction)
        predicted_label = labels[predicted_label_index]

        print("Predicted Label:", predicted_label)
        return jsonify(predicted_label)
    elif number == "EOFSDM":
        # Output the prediction
        if prediction[0][0] >= 0.5:
            print("Predicted: Coincident")
            return jsonify("Coincident")
        else:
            print("Predicted: Shifted")
            return jsonify("Shifted")
    elif number == "EOFSOC":
        # Output the prediction
        if prediction[0][0] >= 0.5:
            print("Predicted: Yes")
            return jsonify("Yes")
        else:
            print("Predicted: No")
            return jsonify("No")
    elif number == "PLFH":
        # Output the prediction
        if prediction[0][0] >= 0.5:
            print("Predicted: Normal")
            return jsonify("Normal")
        else:
            print("Predicted: Reduced")
            return jsonify("Reduced")
    else:
        print("Not found")

if __name__ == '__main__':
    app.run(port=1003)
