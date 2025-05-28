# import pytest
# from .conftest import get_token

# @pytest.mark.asyncio
# async def test_crud_sucursal(async_client):
#     token = await get_token(async_client)
#     headers = {"Authorization": f"Bearer {token}"}

#     # CREATE
#     data = {
#         "nombre": "Sucursal Test",
#         "direccion": "Calle Falsa 123",
#         "ciudad": "TestCity",
#         "telefono": "987654321"
#     }
#     resp = await async_client.post("/sucursales/", json=data, headers=headers)
#     assert resp.status_code == 200
#     sucursal = resp.json()
#     assert sucursal["nombre"] == "Sucursal Test"

#     # READ
#     resp = await async_client.get(f"/sucursales/{sucursal['id_sucursal']}", headers=headers)
#     assert resp.status_code == 200

#     # UPDATE
#     update = data.copy()
#     update["nombre"] = "Sucursal Actualizada"
#     resp = await async_client.put(f"/sucursales/{sucursal['id_sucursal']}", json=update, headers=headers)
#     assert resp.status_code == 200
#     assert resp.json()["nombre"] == "Sucursal Actualizada"

#     # DELETE
#     resp = await async_client.delete(f"/sucursales/{sucursal['id_sucursal']}", headers=headers)
#     assert resp.status_code == 200