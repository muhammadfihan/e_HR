from fractions import Fraction
def pprint(A):
   n = len(A)
   for i in range(0, n):
       line = ""
       for j in range(0, n+1):
           line += str(A[i][j]) + "\t"
           if j == n-1:
               line += "| "
       print(line)
   print("")
   
def gauss(A):
   n = len(A)
   for i in range(0, n):
       # Mencari maksimum dari kolom
       maxE1 = abs(A[i][i])
       maxRow = i
       for k in range(i+1, n):
           # baris pertama tidak bisa dimulai dari 0
           if abs(A[k][i]) < maxE1 or maxE1 == 0:
               maxE1 = abs(A[k][i])
               maxRow = k
       # Menukar baris maksimum dengan baris yang ada (baris dengan baris)
       for k in range(i, n+1):
           tmp = A[maxRow][k]
           A[maxRow][k] = A[i][k]
           A[i][k] = tmp
       for k in range(i+1, n):
           c = -A[k][i]/A[i][i]
           for j in range(i, n+1):
               if i == j:
                   A[k][j] = 0
               else:
                   A[k][j] += c * A[i][j]
   # Print Echelon matriks
   print("Echelon Matrix:\t")
   pprint(A)
   # Penyelesaian
   x = [0 for i in range(n)]
   for i in range(n - 1, -1, -1):
       # TIdak ada asolusi
       if A[i][i] == 0:
           return [0 for i in range(n)]
       # Solusi normal
       else:
           x[i] = A[i][n]/A[i][i]
           for k in range(i-1, -1, -1):
               A[k][n] -= A[k][i]*x[i]
   return x
print('Masukan jumlah variabel :')
n = int(input())
A = [[0 for j in range(n+1)] for i in range(n)]
print("Masukan nilai setiap baris dipisahkan dengan spasi:")
for i in range(0, n):
   line = map(Fraction, input().split(" "))
   for j, el in enumerate(line):
       A[i][j] = el
print("Masukan solusi dari setiap baris dipisahkan dengan spasi :")
line = input().split(" ")
lastLine = list(map(Fraction, line))
for i in range(0, n):
   A[i][n] = lastLine[i]
print("\nMatrix:")
pprint(A)
x = gauss(A)3
print("Hasil:")
solution = False
for i in range(n):
   if x[i] != 0:
       solution = True
if solution:
   for i in range(len(x)):
       print("x", i+1, " = ", x[i])
else:
   print("Tidak Ada Solusi")