# import pytest
# from .conftest import get_token

# @pytest.mark.asyncio
# async def test_crud_vehiculo_sucursal(async_client):
#     token = await get_token(async_client)
#     headers = {"Authorization": f"Bearer {token}"}

#     # Crea sucursal y vehículo para las FK
#     sucursal = {
#         "nombre": "Sucursal VS",
#         "direccion": "Calle VS",
#         "ciudad": "Ciudad VS",
#         "telefono": "5555555"
#     }
#     sucursal_resp = await async_client.post("/sucursales/", json=sucursal, headers=headers)
#     sucursal_id = sucursal_resp.json()["id_sucursal"]

#     # Crea vehículo (ajusta endpoint si no tienes CRUD de vehículo)
#     vehiculo = {
#         "placa": "TEST123",
#         "marca": "MarcaTest",
#         "modelo": "ModeloTest",
#         "anio": 2022,
#         "tipo_id": "Sedan",
#         "estado": "Disponible"
#     }
#     vehiculo_resp = await async_client.post("/vehiculos/", json=vehiculo, headers=headers)
#     vehiculo_id = vehiculo_resp.json()["id_vehiculo"]

#     # CREATE
#     data = {
#         "vehiculo_id": vehiculo_id,
#         "sucursal_id": sucursal_id,
#         "fecha_ingreso": "2024-06-01"
#     }
#     resp = await async_client.post("/vehiculos-sucursal/", json=data, headers=headers)
#     assert resp.status_code == 200
#     relacion = resp.json()
#     assert relacion["vehiculo_id"] == vehiculo_id

#     # READ
#     resp = await async_client.get(f"/vehiculos-sucursal/{relacion['id_relacion']}", headers=headers)
#     assert resp.status_code == 200

#     # UPDATE
#     update = data.copy()
#     update["fecha_ingreso"] = "2024-07-01"
#     resp = await async_client.put(f"/vehiculos-sucursal/{relacion['id_relacion']}", json=update, headers=headers)
#     assert resp.status_code == 200
#     assert resp.json()["fecha_ingreso"] == "2024-07-01"

#     # DELETE
#     resp = await async_client.delete(f"/vehiculos-sucursal/{relacion['id_relacion']}", headers=headers)
#     assert resp.status_code == 200