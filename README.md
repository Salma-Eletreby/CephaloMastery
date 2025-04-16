# CephaloMastery #

CephaloMastery is a tool that takes advanatge of LMS to provide dentistry proffesors 
the ability to examine and teach their students on cephlograms analysis and diagnosis <img align="right" src="https://github.com/sdp23/sdp2324-cs-f-31/assets/123671025/554493f9-88eb-41c4-bee0-cc08e8034e7c" alt="CephaloMastery Image" width="300"/>

1) Cephlometric Landmarks Plugin

    Proffesors upload a cephlogram as a question and have 3 options: add the annotation
    manually, provide the JSON file that contains the annotation or use our own Machine
    Learning Model to provide the annotations for them. Moodle immediatly adds any questions 
    to the question bank so can be reused in other courses, exams or activities. 

    Students can drag points onto the image and after submission recieves feedback on their
    answers.

2) Diagnosis

    Proffesors upload the necessary patient image and have 2 options: fill the options
    manually or choose a question type and use our Machine learning model to provide the 
    answer for them. Moodle immediatly adds any questions to the question bank so can be 
    reused in other courses, exams or activities. 

    Students can answer the questions like standard multiple choice questions.

3) The ML Models

   the code provided in DiagnosisML and LandmarksML is the code that was hosted of our machine learning model and the flask app acting as our API. These are already linked to the necessary plugins. This includes a machine learning model that recieves and image and returns coordinates with labels using YOLO V8 and another machine learning model that receives an image and returns a feature as an answer using CNN.
   the landamrks ML model is too big to upload here, please find it in this link: https://qucloud-my.sharepoint.com/:f:/g/personal/fe2008126_qu_edu_qa/Er7KDbc3HtdAt6bvMET3GxAB_kNP9HAiePiHKw3qDLVahg?e=Qgcp3Q

## Installing via uploaded ZIP file ##

1. Log in to your Moodle site as an admin and go to _Site administration >
   Plugins > Install plugins_.
2. Upload the ZIP file with the plugin code. You should only be prompted to add
   extra details if your plugin type is not automatically detected.
3. Check the plugin validation report and finish the installation.
4. For the usage of our ML a web service token needs to be generated and provided
    to each user who wants to use it.

## Installing manually ##

The plugin can be also installed by putting the contents of this directory to

    {your/moodle/dirroot}/question/type

Afterwards, log in to your Moodle site as an admin and go to _Site administration >
Notifications_ to complete the installation.

Alternatively, you can run

    $ php admin/cli/upgrade.php

to complete the installation from the command line.

## License ##

23/24 SDP <group_31_CS_F>

You should have received a copy of the GNU General Public License along with
this program.  If not, see <https://www.gnu.org/licenses/>.

###### Note that for the plugin development we used the source code for ddmarker and multichoice question type as a base and modified it to fit our need. base code provided by Open Univerity under GNU
