#-------------------------------------------
# Autor: Raul Mauricio Uñate Castro
# Driver Universal Manejo Impresoras TSC En Windows
#-------------------------------------------

# Importacion de Clases.
import argparse
import random
import ctypes
import string
import uuid
import os

# Importaciones.
from pdf2image import convert_from_path
from PIL import Image

# Deficion de funciones

# Function para generar random de 4 letras en mayusculas.
def idUnqique(longitud = 4):
    letters = string.ascii_letters
    idUnqique = ''.join(random.choice(letters) for _ in range(longitud))
    return idUnqique.upper()

# Argumentos CLI.
parser = argparse.ArgumentParser(description='TSCDriver')

# Obligatorios
parser.add_argument('--printer', type=str, required=True, help='Nombre de la impresora.')
parser.add_argument('--copies', type=str, required=True, help='Numero de copias.')
parser.add_argument('--pdf', type=str, required=True, help='Ruta Absoluta Del PDF.')

# Opcionales
parser.add_argument('--size', type=str, required=False, help='Tamaño del GAP.')
parser.add_argument('--margins', type=str, required=False, help='Separación del GAP.')
parser.add_argument('--direction', type=int, required=False, help='Dirección De Impresión.')
parser.add_argument('--scala', type=int, required=False, help='Escala Del Documento En El GAP.')
parser.add_argument('--shaftX', type=int, required=False, help='Pocision en el Eje X.')
parser.add_argument('--shaftY', type=int, required=False, help='Pocision en el Eje Y.')
parser.add_argument('--speed', type=int, required=False, help='Velocidad De Impresion.')
parser.add_argument('--density', type=int, required=False, help='Densidad De Impresion.')

# Crear Objeto con los Argumentos del CLI.
request = parser.parse_args()

# Crear Configuracion por Defecto.
__printer = request.printer
__copies = request.copies
__pdf = request.pdf

# Configuración Opcional Por Defecto.
__size = "100 mm, 80 mm"
__margins = "2.5 mm, 0 mm"
__direction = 1
__scala = (89 * 0.01)
__shaftX = 50
__shaftY = 0
__speed = 4
__density = 8

# Cargar Condfiguracion Opcional Desde Argumentos.
if hasattr(request, 'size') and request.size is not None:
    __size = request.size
    
if hasattr(request, 'margins') and request.margins is not None:
    __margins = request.margins

if hasattr(request, 'direction') and request.direction is not None:
    __direction = request.direction

if hasattr(request, 'scala') and request.scala is not None:
    __scala = (request.scala * 0.01)

if hasattr(request, 'shaftX') and request.shaftX is not None:
    __shaftX = request.shaftX

if hasattr(request, 'shaftY') and request.shaftY is not None:
    __shaftY = request.shaftY

# Obtener el directorio actual del script.
current_path = os.path.dirname(os.path.abspath(__file__))

# Leer PDF
pdf = convert_from_path(__pdf)

# Generar Identificador Unico.
unique_id = uuid.uuid4()

# Ruta Nueva imagen PCX.
pathPCX = os.path.join(current_path, "temp", f"{unique_id}.PCX")

# Generar PCX desde el PDF.
for i, label in enumerate(pdf):

    # Debe alojarse en B/N (L).
    labelPCX = label.convert("L")

    # Redimensionar la imagen manteniendo la proporción
    imageHeight = int(labelPCX.height * __scala)
    imageWidth = int(labelPCX.width * __scala)
    imageLbelPCX = labelPCX.resize((imageWidth, imageHeight), resample=Image.LANCZOS)

    #Guardar Imagen
    imageLbelPCX.save(pathPCX)

# Cargar la DLL
tsclibrary = ctypes.WinDLL(os.path.join(current_path, "libs", "TSCLIB.dll"))

# Ejecutar Impresión.
if __name__ == '__main__':
    pass

try:

    # Nombre De La Impresora.
    tsclibrary.openportW(__printer)

    # Tamaño del GAP
    tsclibrary.sendcommandW(f"SIZE {__size}")

    # Separacion tamño GAP
    tsclibrary.sendcommandW(f"GAP {__margins}")

    # Velocidad de impresion
    tsclibrary.sendcommandW(f"SPEED {__speed}")

    # Densidad de impresion
    tsclibrary.sendcommandW(f"DENSITY {__density}")

    # Direccion
    tsclibrary.sendcommandW(f"DIRECTION {__direction}")

    # Limpiar TSC
    tsclibrary.sendcommandW("CLS")

    # Valores para descargar el PCX en la impresora.
    randomId = idUnqique()
    download_path = os.path.join(current_path, "temp", f"{unique_id}.PCX")

    # Descargar archivo DRAM
    tsclibrary.downloadpcxW(download_path, f"{randomId}.PCX")

    # Cargar PCX en la impresora 
    tsclibrary.sendcommandW(f"PUTPCX {__shaftX},{__shaftY},\"{randomId}.PCX\"")

    # Imprimir
    tsclibrary.printlabelW("1",f"{__copies}")

    # Cerrar la Conexion a la impresora
    tsclibrary.closeport()

    # Eliminar Archivo
    os.remove(pathPCX)

    # Salida Ejecucion
    print("OK")

except Exception as e:

    print(f"Exception: {e}")