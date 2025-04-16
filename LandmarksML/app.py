from flask import Flask, jsonify, request
from flask_cors import CORS
import cv2
from math import *
from ultralytics import YOLO 
import os
import requests
from io import BytesIO
import numpy as np

app = Flask(__name__)
CORS(app)  # Configure CORS for the entire app


# to send the pic teacher uploaded to student
# Define a directory to store uploaded images
UPLOAD_FOLDER = 'uploaded_images'
app.config['UPLOAD_FOLDER'] = UPLOAD_FOLDER


@app.route('/get_keypoints', methods=['GET'])
def get_keypoints():
    print ("hello")
    points_with_coordinates = label_points(image_path, model_path, keypoint_names)
    response = jsonify(points_with_coordinates)
    response.headers.add('Access-Control-Allow-Origin', '*')
    # You can convert the array to JSON format
    return response


#image 
@app.route('/get_points', methods=['Post'])
def get_points():
    imgUrl = request.data.decode("utf-8")
    try:
        response = requests.get(imgUrl)
        image_bytes = BytesIO(response.content)
        img = cv2.imdecode(np.asarray(bytearray(image_bytes.read()), dtype=np.uint8), 1)
        print(img)
        if response.status_code == 200:
            points_with_coordinates = label_points(img, model_path, keypoint_names)
            response = jsonify(points_with_coordinates)
            response.headers.add('Access-Control-Allow-Origin', '*')
            return response
        else:
            print('Failed to fetch image. Status code:', response.status_code)
    except Exception as e:
        print('There was a problem with the request:', e)



def label_points(imgUrl, model_path, keypoint_names):
    points_array = []
    
    # img = cv2.imread(imgUrl)
    model = YOLO(model_path)
    results = model(imgUrl)[0]
    
    for idx, keypoint in enumerate(results.keypoints.xy[0]):
        point = tuple(keypoint.tolist())
        rounded_point = tuple([round(i) for i in point])
        
         # Subtract the correct number from both dimensions of the point if needed
        adjusted_point = (point[0], point[1])

        keypoint_name = keypoint_names[idx]
        coordinates_str = f"({point[0]}, {point[1]})"
        
        points_array.append({
            "keypoint_name": keypoint_name,
            "coordinates": adjusted_point,
        })
    
    return points_array

# image_path = "HC000210580_0.jpg"
model_path = "backend/best.pt"
keypoint_names = ["Sella" ,"Nasion", "Orbitale","Porion","Subspinale","Supramentale","Pogonion","Menton","Gnathion","Gonion","Incision inferius","Incision superius","Upper lip","Lower lip","Subnasale","Soft tissue pogonion","Posterior nasal spine","Anterior nasal spine","Articulare"] 

if __name__ == '__main__':
    app.run(port=1002)
