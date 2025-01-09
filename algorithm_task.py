from algorithm import Algorithm


algorithm = Algorithm()

# Task 1 
algorithm.value = [2, 1, 5, 7, 4, -8, -3, -1]

print(f"Task 1 => mencari 3 angka array jika dijumlahkan bernilai 0 \n{algorithm.get_zero_point()}")
print("===============================================")

# Task 2
algorithm.value = [1, 1, 4, 4, 4, 5, 5, 6, 8, 9,10, 10, 12, 13, 13, 17]

print(f"Task 2 => mencari nilai unique di dalam list \n{algorithm.get_unique_data()}")
print("===============================================")

# Task 3
algorithm.value = [2, 5, 1, 12, -5, 4, -1, 3, -3, 20, 8, 7, -2, 6, 9]

print("Task 3 => sorting data secara ascending, setiap kelipatan 5 sorting secara descending")
print(algorithm.get_sorted_data(step=5))
print("===============================================")

# Task 4
print("Task 4 => mencari kata simetris")

algorithm.value = "madam"
print(f"Apakah kata 'madam' simetris? \n{algorithm.is_simmetric_string()}")

algorithm.value = "gozaru"
print(f"Apakah kata 'gozaru' simetris? \n{algorithm.is_simmetric_string()}")