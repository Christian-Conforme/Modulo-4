# import pytest
# from .conftest import get_token

# @pytest.mark.asyncio
# async def test_crud_rol(async_client):
#     token = await get_token(async_client)
#     headers = {"Authorization": f"Bearer {token}"}

#     # CREATE
#     data = {"nombre": "RolTest"}
#     resp = await async_client.post("/roles/", json=data, headers=headers)
#     assert resp.status_code == 200
#     rol = resp.json()
#     assert rol["nombre"] == "RolTest"

#     # READ
#     resp = await async_client.get(f"/roles/{rol['id_rol']}", headers=headers)
#     assert resp.status_code == 200

#     # UPDATE
#     update = {"nombre": "RolActualizado"}
#     resp = await async_client.put(f"/roles/{rol['id_rol']}", json=update, headers=headers)
#     assert resp.status_code == 200
#     assert resp.json()["nombre"] == "RolActualizado"

#     # DELETE
#     resp = await async_client.delete(f"/roles/{rol['id_rol']}", headers=headers)
#     assert resp.status_code == 200