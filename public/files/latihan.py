import math
import matplotlib.pyplot as plt
import seaborn as sns
import numpy as np
def biseksi(fx):
    a = float(input("Masukan a: "))
    b = float(input("Masukan b: "))
    c = a 
    print ("a\tb\tfx(a)\tfx(b)\tc\tfx(c)")
    if(fx(a)*fx(b) < 0):
        while (abs(fx(a)*fx(b)) > 0.000001):
            c = (a+b)/2
            print (f'{a:.3f}\t{b:.3f}\t{fx(a):.3f}\t{fx(b):.3f}\t{c:.3f}\t{fx(c):.3f}')
            if(fx(a)*fx(c)>0):
                a = c
            else:
                b = c 
        print (f'Akar persamaan adalah {c:.3f}')
    else:
        print ('Tebakan Awal a dan b salah')
fx = lambda x: x**3 - 2*(x**2) + 6*x -4.0
biseksi(fx)      
