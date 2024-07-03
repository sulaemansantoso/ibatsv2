import sys
import cv2
import numpy as np
import os
import json
import time
import mysql.connector


CASCADE_DIR = "haarcascades"
FACE_CLSF="haarcascade_frontalface_alt.xml"
ROOT_DIR = "laravel/public/public_images/"
OUTPUT_DIR = "output/"
PUBLIC_OUTPUT_DIR = "/output/"

file_dir = 'public/public_images/2018/Genap'
mydb = mysql.connector.connect(
    host='localhost',
    user='testUser',
    passwd='bose12345*',
    database='IBDB'
)

'''
    ini bisa dengan 2 macam pendekatan
    1. file based approach
        a. buka file_dir get semua non-output jpg
        b. iterate non-output jpg with same process as split image to get region
        c. foreach file name look it up on the database to know id photo n attendances
        d. rebuilt json file from info
    2. data based approach [approach taken]
        a. query to get all .jpg yang untuk semester ini
        b. iterate with same process as split iamge to get region
        c. foreach file name look it up on database to know id photo n attendances
        d. rebuilt json file from info
'''
def renew_json(param) :
    classifier = cv2.CascadeClassifier(os.path.join(CASCADE_DIR,
                                                         FACE_CLSF))

    if(not os.path.isfile(os.path.join(CASCADE_DIR,FACE_CLSF))):
        print('\nfile not found :  ' + os.path.join(CASCADE_DIR,FACE_CLSF))
        return
    scaleFactor=1.1
    minNeighbors=5
    db_cursor = mydb.cursor(buffered=True)
    sql = """select p.Id, p.Path , s.Id, sc.Id from photos p
                join schedule_photos sc on (sc.Id_Photo = p.Id)
                join schedules s on (sc.Id_Schedule = s.Id)
                join classes c on (s.Id_Class = c.Id)
                join lessons l on (c.Id_Lesson = l.Id)
                join semesters smt on (l.Id_Semester = smt.Id)
                where smt.Id = 5
          """
    db_cursor.execute(sql)
    result = db_cursor.fetchall()
    num_files = db_cursor.rowcount
    j=0
    for rows in result :
        j = j+1
        (id, path, id_schedule, id_schedule_photo) = rows;
        (filepath, filename) = get_filepath(path)

        public_filepath = "http://124.81.122.93/laravel/public/public_images/2018/" + filepath + "/"
        local_filepath = "public/public_images/2018/" + filepath  + "/"
        local_filenamepath =  local_filepath + filename

        name = os.path.splitext(filename)[0]

        if(not os.path.isfile(local_filenamepath)):
            print('\nfile not found :  ' + local_filenamepath)
            continue
            #print('\nfile found : ' + local_filenamepath)
        img = cv2.imread(local_filenamepath)
        gray_img = cv2.cvtColor(src=img, code=cv2.COLOR_BGR2GRAY)
        # detect faces
        faces = classifier.detectMultiScale(image=gray_img, scaleFactor=scaleFactor,minNeighbors=minNeighbors)
        length_faces = len(faces)
        faces_to_json = []
        i=0
        for (x, y, w, h) in faces:
            cropped = img[y:y+h, x:x+w]

            id_photo=""
            path = ""
            nrp=""
            nama=""

            i = i+1
            output_path =  local_filepath + "/" + OUTPUT_DIR + name + '-' + str(i) + '.jpg'
            '''this needs to be checked ini buat ngesql photo and schedulephoto'''
            public_output_path = public_filepath + "/" +  OUTPUT_DIR + name + '-' + str(i) + '.jpg' #diset ulang untuk file output
             #diset ulang untuk file output

            #got the Path
            sql = "select Id, Path from photos where Path = \"" + public_output_path + "\""
            row =db_cursor.execute(sql)
            if (db_cursor.rowcount > 0):
                (id_photo,path) = db_cursor.fetchone()
                sql = 'select s.UserId, s.Name from attendances att join users s on (att.Id_Student = s.Id) where att.Id_Photo=' + str(id_photo) + ";"

                db_cursor.execute(sql)
                if (db_cursor.rowcount >0):
                    (nrp, nama) = db_cursor.fetchone()


            rect = {'color': '#00ff00', 'x': int(x), 'y': int(y),
                'width': int(w), 'height': int(h), 'NRP' : nrp,'Name':nama,'Id_Photo': id_photo }
            faces_to_json.append(rect)

        #json_output_path = local_filepath +  name + '-' +  'b.json'
        json_output_path = local_filepath +  name + '.json'
        #print faces_to_json
        sys.stdout.write("\rwriting " + str(j) + "/" + str(num_files) + "\n" )
        sys.stdout.flush()
        with open(json_output_path,'w') as myfile :
            json.dump(faces_to_json,myfile,indent=4, sort_keys=True);
        #print str(id) +  "   " + filename


def get_filepath(fullpath) :
    splits = fullpath.split('/')
    filename = splits[-1]
    filepath = splits[-5:-1]
    return ['/'.join(filepath),filename]

renew_json(0)
