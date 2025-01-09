from typing import List, Any

class Algorithm:

    def __init__(self, value: Any = None):
        self.__value = value

    def get_zero_point(self) -> List[List[int]]:
        output = []
        for i, arr in enumerate(self.__value):
            for j, arr2 in enumerate(self.__value):
                for k, arr3 in enumerate(self.__value):
                    if i == j or k == j or k == i:
                        continue
                    array = [arr, arr2, arr3]
                    count = arr + arr2 + arr3
                    output.append(array) if count == 0 else None
        
        return output
            
    def get_unique_data(self) -> List[int]:
        if not isinstance(self.__value, list):
            raise ValueError("Value must be list of integer")
        output = list(set(self.__value))

        return output
    
    def get_sorted_data(self, step: int = 5) -> List[List[int]]:
        if not isinstance(self.__value, list):
            raise ValueError("Value must be list of integer")
        
        split_data = [self.__value[i:i+step] for i in range(0, len(self.__value), step)]
        output = []

        for idx, array in enumerate(split_data):
            if idx % 2 == 0:
                data = Algorithm.asc(array)
                output.append(data)
            else:
                data = Algorithm.desc(array)
                output.append(data)

        return output
    
    def is_simmetric_string(self) -> bool:
        if not isinstance(self.__value, str):
            raise ValueError("Value must be string")
        return True if self.__value == self.__value[::-1] else False
    
    @staticmethod
    def asc(array):
        for i in range(len(array)):
            for j in range(len(array) - 1):
                if array[j] >= array[j + 1]:
                    array[j], array[j + 1] = array[j + 1], array[j]
        return array

    @staticmethod
    def desc(array):
        return Algorithm.asc(array)[::-1]
    
    @property
    def value(self):
        return self.__value
    
    @value.setter
    def value(self, new_value):
        self.__value = new_value