import sys
import cv2
import numpy as np
import os
import json
import mysql.connector
import face_recognition

CASCADE_DIR = "../haarcascades"
FACE_CLSF="haarcascade_frontalface_alt.xml"
# FACE_CLSF="haarcascade_frontalface_alt_tree.xml"
# FACE_CLSF="haarcascade_frontalface_alt2.xml"
# FACE_CLSF="haarcascade_frontalface_default.xml"


ROOT_DIR = "../storage/app/public/photo/"
OUTPUT_DIR = "output/"
PUBLIC_OUTPUT_DIR = "/output/"

'''connection initialization '''
mydb = mysql.connector.connect(
    host='localhost',
    user='ibats_admin',
    passwd='galath34',
    database='IBDB2'
)

def detect_faces(filepath, classifier,file_name, id_pertemuan, scaleFactor=1.1, minNeighbors=3):

    '''Detect faces in an image and save the detection as json file'''
    public_folderpath = "http://114.7.152.254/ibatsv2/public/photo/" + filepath + "/"
    local_folderpath = "../storage/app/public/photo/" + filepath + "/"

    # arr = os.listdir('../storage/app/public')
    # print(arr)
    # print("----------------------------------")

    #print ("\nfile_to_read "  + filepath + file_name)
    # load image file
    local_file_total_path =  local_folderpath + file_name

    if(os.path.isfile(local_file_total_path)):
        print('\nfile found : ' + local_file_total_path)
    else :
        print('\nfile not found :  ' + local_file_total_path)

    img = cv2.imread(local_file_total_path)
    # Ubah gambar ke format RGB (face_recognition menggunakan format ini)
    rgb_image = cv2.cvtColor(img, cv2.COLOR_BGR2RGB)

    # Deteksi lokasi wajah dalam gambar
    faces = face_recognition.face_locations(rgb_image)

    # convert image to grayscale
    # gray_img = cv2.cvtColor(src=img, code=cv2.COLOR_BGR2GRAY)

    # detect faces
    #faces = classifier.detectMultiScale(image=gray_img,
    #                                    scaleFactor=scaleFactor,
    #                                    minNeighbors=minNeighbors)
    #harus mengubah filepath jadi public_filepath
    (name,delimit,ext) = file_name.rpartition('.')

    print('\npublic_filepath ' + public_folderpath)
    print('\nlocal_filepath ' + local_folderpath)


    # record detected face areas into a list of dictionary
    faces_to_json = []
    sql_to_json = []
    i=0
    for (x, y, w, h) in faces:
        cropped = img[y:y+h, x:x+w]
        i = i+1
        output_path =  local_folderpath +  OUTPUT_DIR + name + '-' + str(i) + '.jpg'
        output_log_path = local_folderpath + filepath +  OUTPUT_DIR + name + '-' + str(i) + '.log'

        if (not os.path.isdir(local_folderpath + OUTPUT_DIR)):
            os.mkdir(local_folderpath +  OUTPUT_DIR) #create directory output apabila diperlukan

        cv2.imwrite( output_path, cropped) #cropped image saved to output_folder

        '''this needs to be checked ini buat ngesql photo and schedulephoto'''
        #output_path = local_folderpath  + OUTPUT_DIR + name + '-' + str(i) + '.jpg' #diset ulang untuk file output
        public_path = public_folderpath  + OUTPUT_DIR + name + '-' + str(i) + '.jpg' #diset ulang untuk file output

        my_cursor = mydb.cursor()
        sql ="insert into photo (path) values('"+ public_path +"')"
        print(sql)
        sql_to_json.append(sql)
        my_cursor.execute(sql)#execute insert photo

        last_photo_id = my_cursor.lastrowid
        sql="insert into pertemuan_photo(Id_Pertemuan, Id_Photo) values( '"+id_pertemuan+ "','" + str(last_photo_id)   +  "' )"
        print(sql)
        sql_to_json.append(sql)
        my_cursor.execute(sql)

        '''   '''

        rect = {'color': '#00ff00', 'x': int(x), 'y': int(y),
                'width': int(w), 'height': int(h), 'NRP' : '','Name':'','Id_Photo': str(last_photo_id) }
        faces_to_json.append(rect)
    # save detected face areas as json file
    with open( local_folderpath + name + '.json', 'w') as outfile:
        json.dump(obj=faces_to_json, fp=outfile, indent=4)

    #with open('../public/' + filepath + name + '.log', 'w' ) as logfile :
        #json.dump(obj=sql_to_json,fp=logfile,indent=4)

    #create meta file
    sql = "select  m.id_mk, m.nama_mk, c.nama_kelas \
       from kelas c \
	   join mk m on (c.id_mk = m.id_mk) \
       join pertemuan p on (p.id_kelas = c.id_kelas)\
       where p.Id_pertemuan=" + id_pertemuan
    print(sql)
    my_cursor.execute(sql)
    myresult = my_cursor.fetchone()
    meta = {'SubjectId': myresult[0] , 'SubjectName':myresult[1] ,'ClassNumber': myresult[2]}
    with open( local_folderpath + 'meta.json', 'w') as outfile:
        json.dump(obj=meta, fp=outfile, indent=4)

    mydb.commit()
    my_cursor.close()

def main():

    # '''main function'''
    arg_length = sys.argv
    destinationPath = sys.argv[1]
    file_name = sys.argv[2]
    idSchedulePhoto = sys.argv[3]

    print ('destination path : ' +  destinationPath + "\n filename path :  " + file_name + "\n")
    if (os.path.isfile(os.path.join(CASCADE_DIR, FACE_CLSF))):
        print('classfier found')
    face_classifier = cv2.CascadeClassifier(os.path.join(CASCADE_DIR,
                                                         FACE_CLSF))
    detect_faces(destinationPath, face_classifier,file_name, idSchedulePhoto)
    #print("jalan loh")

    mydb.close()

if __name__ == "__main__":
    main()
