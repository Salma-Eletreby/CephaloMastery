import urllib.request
import numpy as np
import cv2
import os
import hashlib
import requests

# def download_image(url, filename):
#     try:
#         urllib.request.urlretrieve(url, filename)
#         return True
#     except Exception as e:
#         print(f"Failed to download the image: {e}")
#         return False

# def download_image(url, filename):
#     try:
#         response = requests.get(url)
#         if response.status_code == 200:
#             with open(filename, 'wb') as f:
#                 f.write(response.content)
#             return True
#         else:
#             print("Failed to download the image. HTTP status code:", response.status_code)
#             return False
#     except Exception as e:
#         print(f"Failed to download the image: {e}")
#         return False
# URL of the image to download
image_url = "http://localhost:8080/moodle/draftfile.php/5/user/draft/441723517/download.jpeg"



cookie_str = 'MoZjYmEwNzhlYjY4MzE=|"'  # Replace 'your_cookie_string_here' with the actual cookie string

headers = {'Cookie': cookie_str}

response = requests.get(image_url, headers=headers)

if response.status_code == 200:
    with open('image.jpg', 'wb') as f:
        f.write(response.content)
    print('Image downloaded successfully')
else:
    print('Failed to download the image')
def calculate_md5(file_path):
    md5_hash = hashlib.md5()
    with open(file_path, "rb") as f:
        for chunk in iter(lambda: f.read(4096), b""):
            md5_hash.update(chunk)
    return md5_hash.hexdigest()

# Example usage:
md5_checksum = calculate_md5(r"C:\Users\aya20\Pictures\download.jpeg")

print("MD5 checksum before download:", md5_checksum)
# Directory where the Python script resides

script_dir = os.path.dirname(os.path.abspath(__file__))
# Full file path for the downloaded image
image_path = os.path.join(script_dir, 'image.jpeg')

md5_checksum2 = calculate_md5(image_path)
print("MD5 checksum after download :", md5_checksum2)
# File name for the downloaded image
image_filename = "Ceph.jpeg"

# Full file path for the downloaded image
image_path = os.path.join(script_dir, image_filename)

# Download the image
# if download_image(image_url, image_path):
#     # Read the downloaded image using OpenCV
#     img = cv2.imread(image_path)
#     if img is not None:
#         # Proceed with your processing
#         # For example:
#         print(image_path)
#         gray_img = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
#         # ...other image processing operations...
#     else:
#         md5_checksum2 = calculate_md5(image_path)
#         print("MD5 checksum after download :", md5_checksum2)
#         print(image_path)
#         print("Failed to read the downloaded image.")
        
# else:
#     print("Failed to download the image.")

