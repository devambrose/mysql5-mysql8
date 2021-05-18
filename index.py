import os


def convert_to_php(filename):
    file1 = open(filename, 'r')
    lines = file1.readlines()

    string_list = []

    for line in lines:
        string = line.strip()

        if string.find("<?") != -1:
            string = string.replace("<?", "<?php")
            string = string.replace("<?phpphp", "<?php")

        elif string.find("mysql") != -1:
            string = string.replace("mysql_", "mysqli_") + "\n"

        string_list.append(string)
    file1.close()

    file1 = open(filename, "w")
    file1.write("\n".join(string_list))

    file1.close()


def fetch_files(folder):
    with os.scandir(folder) as entries:
        for entry in entries:
            if entry.is_file():
                if entry.name.split(".")[1] == "php":
                    print("File name------------" + entry.name + "    -----------------\n")
                    convert_to_php(folder + entry.name)
            else:
                print("folder: " + entry.name)
                fetch_files(folder + "/" + entry.name + "/")


# fetch_files("./")

convert_to_php("addcustomers.php")
